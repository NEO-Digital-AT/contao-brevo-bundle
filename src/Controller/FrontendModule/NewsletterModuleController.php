<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\InsertTag\InsertTagParser;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Brevo newsletter sign-up as a Contao FRONTEND MODULE (group "neo" of the
 * front-end modules, named by the Basic bundle). Configure one module per use
 * case in the back end — target list(s), mode, double-opt-in template,
 * confirmation redirect and all copy — then drop it into the page via the
 * standard "Module" content element. Two modes:
 *  - "fixed": the contact is added to all configured list(s); no list UI.
 *  - "choice": the visitor picks from the configured lists (single select or
 *    checkboxes); per-list labels can be renamed.
 *
 * The form posts to the subscribe endpoint, which re-derives the authorised
 * list(s) from this module — list ids are never trusted from the client. The
 * shared API key comes from "Access keys and licences" (Basic bundle); Brevo
 * sends the opt-in mail.
 */
#[AsFrontendModule('brevo_newsletter', category: 'neo', template: 'frontend_module/brevo_newsletter')]
final class NewsletterModuleController extends AbstractFrontendModuleController
{
    public const ENDPOINT = '/api/brevo/subscribe';

    public function __construct(
        private readonly InsertTagParser $insertTags,
        private readonly BrevoClient $brevo,
        private readonly ApiKeyResolver $apiKeys,
        private readonly TranslatorInterface $translator,
    ) {
    }

    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        // Multilingual sites: one module per language (own lists, DOI template,
        // confirmation page and texts), placed on that language's pages. Fixed
        // texts come from translations/neo_brevo.<lang>.yaml in the page language;
        // the module's own fields override them.
        $page = $request->attributes->get('pageModel');
        $locale = str_replace('-', '_', $page instanceof PageModel ? (string) $page->language : ($request->getLocale() ?: 'en'));
        $t = fn (string $key): string => $this->translator->trans('form.'.$key, [], 'neo_brevo', $locale);
        $own = static fn (string $field): string => trim((string) $model->{$field});

        // Contao stores the headline HTML-encoded. The template outputs it with |raw
        // (so that an accent <span> from the design takes effect) — without decoding,
        // the browser would show the literal <span …>…</span> markup instead of the
        // highlighted words.
        $headline = StringUtil::deserialize($model->headline, true);
        $template->set('headline', StringUtil::decodeEntities((string) ($headline['value'] ?? '')));
        $template->set('headlineTag', \in_array($headline['unit'] ?? '', ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], true) ? $headline['unit'] : 'h2');

        $template->set('intro', $model->brevo_intro);
        $template->set('emailLabel', $model->brevo_email_label ?: $t('email_label'));
        $template->set('button', $model->brevo_button ?: $t('button'));
        // Consent text may carry an insert-tag link (e.g. {{link::datenschutz::…}}).
        $template->set('consent', $this->insertTags->replaceInline((string) $model->brevo_consent));
        $template->set('success', $model->brevo_success ?: $t('success'));
        $template->set('genericError', $own('brevo_error_generic') ?: $t('error_generic'));
        // Specific messages instead of the generic one: a visitor who mistypes should be
        // told so — "something went wrong" does not help anyone.
        $template->set('invalidError', $own('brevo_error_invalid') ?: $t('error_invalid'));
        $template->set('limitError', $own('brevo_error_limit') ?: $t('error_limit'));
        $template->set('chooseError', $own('brevo_error_choose') ?: $t('error_choose'));

        $mode = 'choice' === $model->brevo_mode ? 'choice' : 'fixed';
        $template->set('mode', $mode);
        $template->set('choiceType', 'multiple' === $model->brevo_choice_type ? 'multiple' : 'single');
        $template->set('lists', 'choice' === $mode ? $this->buildOptions($model) : []);

        $template->set('modId', (int) $model->id);
        $template->set('endpoint', self::ENDPOINT);
        $template->set('configured', $this->isConfigured($model));
        $template->set('listsLegend', $own('brevo_lists_label') ?: $t('lists_legend'));
        $template->set('listLabel', $t('list_label'));

        return $template->getResponse();
    }

    /**
     * Builds the selectable lists for "choice" mode: the configured list ids paired
     * with a display label (per-list rename override, else the live Brevo name).
     *
     * @return list<array{id: int, label: string}>
     */
    private function buildOptions(ModuleModel $model): array
    {
        $ids = array_values(array_filter(array_map('intval', StringUtil::deserialize($model->brevo_lists, true))));

        if ([] === $ids) {
            return [];
        }

        $names = $this->brevo->getLists($this->apiKey());
        $overrides = [];

        foreach (StringUtil::deserialize($model->brevo_list_labels, true) as $row) {
            if (isset($row['key'], $row['value']) && '' !== trim((string) $row['value'])) {
                $overrides[(int) $row['key']] = (string) $row['value'];
            }
        }

        $options = [];

        foreach ($ids as $id) {
            $options[] = [
                'id' => $id,
                'label' => $overrides[$id] ?? ($names[$id] ?? '#'.$id),
            ];
        }

        return $options;
    }

    private function apiKey(): string
    {
        return $this->apiKeys->resolve();
    }

    private function isConfigured(ModuleModel $model): bool
    {
        $lists = array_filter(array_map('intval', StringUtil::deserialize($model->brevo_lists, true)));

        return '' !== $this->apiKey()
            && [] !== $lists
            && (int) $model->brevo_doi_template > 0
            && (int) $model->brevo_redirect > 0;
    }
}
