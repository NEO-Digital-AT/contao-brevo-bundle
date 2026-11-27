<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\Form;
use Contao\FormFieldModel;
use Contao\PageModel;
use Contao\StringUtil;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Neo\BrevoNewsletterBundle\Subscription\SignupGuard;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Handles the form generator's "Brevo sign-up" fields (brevo_optin): if the
 * visitor ticked the opt-in, the address is subscribed to Brevo via double
 * opt-in. Which form fields supply e-mail/first/last name and which list(s) the
 * contact goes into is configured on the field itself (tl_form_field).
 * Errors go to the application log and, as errors, to Contao's system log
 * (System › System log) — they NEVER disturb the rest of the form processing
 * (e.g. sending the e-mail of a contact request).
 *
 * Spam protection: one confirmation e-mail per address in 24 hours (SignupGuard),
 * like the front-end module. Against bots, protect the form itself with Contao's
 * ALTCHA field (form generator › field type "ALTCHA").
 */
#[AsHook('processFormData')]
final class BrevoOptinFormListener
{
    public function __construct(
        private readonly BrevoClient $brevo,
        private readonly ApiKeyResolver $apiKeys,
        private readonly ContentUrlGenerator $urls,
        private readonly ContaoFramework $framework,
        private readonly LoggerInterface|null $logger = null,
        private readonly LoggerInterface|null $contaoErrorLog = null,
        private readonly SignupGuard|null $guard = null,
    ) {
    }

    /**
     * Contao 5 signature: (submitted data, form config, files, labels, form).
     *
     * @param array<string, mixed> $submitted
     * @param array<string, mixed> $formData
     * @param array<string, mixed> $files
     * @param array<string, mixed> $labels
     */
    public function __invoke(array $submitted, array $formData, array $files, array $labels, Form $form): void
    {
        $fields = $this->framework->getAdapter(FormFieldModel::class)->findBy(
            ["tl_form_field.pid = ? AND tl_form_field.type = 'brevo_optin' AND tl_form_field.invisible != 1"],
            [(int) $form->id],
        );

        foreach ($fields ?? [] as $field) {
            if (empty($submitted[$field->name])) {
                continue; // Opt-in not ticked — nothing to do.
            }

            try {
                $this->subscribe($field, $submitted);
            } catch (\Throwable $e) {
                // The address is deliberately not logged.
                $this->logger?->error('Brevo opt-in from the form failed: '.$e->getMessage(), ['exception' => $e]);
                $this->systemLog($field, mb_substr($e->getMessage(), 0, 300));
            }
        }
    }

    /**
     * @param array<string, mixed> $submitted
     */
    private function subscribe(FormFieldModel $field, array $submitted): void
    {
        $email = filter_var(trim((string) ($submitted[$field->brevo_email_field] ?? '')), FILTER_VALIDATE_EMAIL);

        if (false === $email) {
            return;
        }

        // A confirmation e-mail went to this address within 24 hours: none again.
        if (null !== $this->guard && $this->guard->addressSeen($email)) {
            return;
        }

        $lists = array_values(array_filter(array_map('intval', StringUtil::deserialize($field->brevo_lists, true))));
        $templateId = (int) $field->brevo_doi_template;
        $redirectPage = $this->framework->getAdapter(PageModel::class)->findByPk((int) $field->brevo_redirect);
        $redirect = $redirectPage instanceof PageModel ? $this->urls->generate($redirectPage, [], UrlGeneratorInterface::ABSOLUTE_URL) : '';
        $apiKey = $this->apiKeys->resolve();

        if ('' === $apiKey || [] === $lists || $templateId < 1 || '' === $redirect) {
            $this->logger?->warning(sprintf(
                'Brevo opt-in "%s" (form field %d) is not fully configured (key/list/DOI template/confirmation page) — sign-up skipped.',
                (string) $field->name,
                (int) $field->id,
            ));
            $missing = array_keys(array_filter(['API key' => '' === $apiKey, 'list' => [] === $lists, 'DOI template' => $templateId < 1, 'confirmation page' => '' === $redirect]));
            $this->systemLog($field, 'the field is not complete (missing: '.implode(', ', $missing).')');

            return;
        }

        $attributes = [];
        $firstName = trim((string) ($submitted[$field->brevo_firstname_field] ?? ''));
        $lastName = trim((string) ($submitted[$field->brevo_lastname_field] ?? ''));

        if ('' !== $firstName) {
            $attributes['VORNAME'] = $firstName;
        }

        if ('' !== $lastName) {
            $attributes['NACHNAME'] = $lastName;
        }

        // Send the names along (German Brevo accounts name these attributes
        // VORNAME/NACHNAME). If the account does not know the attributes, Brevo
        // rejects the request — the sign-up matters more than the name, so a
        // second attempt goes without attributes.
        $ok = $this->brevo->createDoiContact($apiKey, $email, $lists, $templateId, $redirect, $attributes);

        if (!$ok && [] !== $attributes) {
            $ok = $this->brevo->createDoiContact($apiKey, $email, $lists, $templateId, $redirect);
        }

        if ($ok) {
            $this->guard?->record($email);
        }

        if (!$ok) {
            $this->logger?->warning('Brevo did not accept the opt-in sign-up from the form.');
            $this->systemLog($field, 'Brevo refused it ('.$this->brevo->lastError().')');
        }
    }

    /** System › System log: the visitor was not subscribed (without the visitor's address). */
    private function systemLog(FormFieldModel $field, string $reason): void
    {
        $this->contaoErrorLog?->error(\sprintf(
            'Brevo newsletter: the sign-up through the form field "%s" (ID %d, form ID %d) failed, the visitor was not subscribed; the form was processed as usual: %s.',
            (string) $field->name,
            (int) $field->id,
            (int) $field->pid,
            $reason,
        ));
    }
}
