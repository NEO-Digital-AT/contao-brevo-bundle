<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\EventListener;

use Contao\ArticleModel;
use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\LayoutModel;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\StringUtil;

/**
 * Enqueues the newsletter CSS/JS via the layout (TL_CSS / TL_JAVASCRIPT) so Contao
 * combines and minifies them with the rest of the page assets — never a raw
 * <link>/<script> in the template. Loaded only on pages that actually use the
 * brevo_newsletter front-end module (placed via a "module" content element or in a
 * layout section), and only on the main request.
 */
final class AssetListener
{
    #[AsHook('getPageLayout')]
    public function onGetPageLayout(PageModel $page, LayoutModel $layout, PageRegular $pageRegular): void
    {
        $modIds = $this->newsletterModuleIds();

        if ([] === $modIds) {
            return;
        }

        if (!$this->inContent((int) $page->id, $modIds) && !$this->inLayout($layout, $modIds)) {
            return;
        }

        $GLOBALS['TL_CSS']['neo_brevo_newsletter'] = 'bundles/neobrevonewsletter/brevo-newsletter.css|all|static';
        // |async: the script waits for DOMContentLoaded itself, so it must not
        // block HTML parsing in the <head>.
        $GLOBALS['TL_JAVASCRIPT']['neo_brevo_newsletter'] = 'bundles/neobrevonewsletter/brevo-newsletter.js|async|static';
    }

    /**
     * @return list<int> ids of all brevo_newsletter front-end modules
     */
    private function newsletterModuleIds(): array
    {
        $modules = ModuleModel::findBy(["tl_module.type = 'brevo_newsletter'"], []);

        return null === $modules ? [] : array_map('intval', $modules->fetchEach('id'));
    }

    /**
     * A "module" content element on the page references one of the newsletter modules.
     *
     * @param list<int> $modIds
     */
    private function inContent(int $pageId, array $modIds): bool
    {
        $articles = ArticleModel::findBy(['tl_article.pid = ?'], [$pageId]);

        if (null === $articles) {
            return false;
        }

        $artIds = array_map('intval', $articles->fetchEach('id'));

        if ([] === $artIds) {
            return false;
        }

        return ContentModel::countBy(
            [
                "tl_content.ptable = 'tl_article'",
                'tl_content.pid IN ('.implode(',', $artIds).')',
                "tl_content.type = 'module'",
                'tl_content.module IN ('.implode(',', $modIds).')',
                "tl_content.invisible = ''",
            ],
            [],
        ) > 0;
    }

    /**
     * A newsletter module is placed directly in a layout section.
     *
     * @param list<int> $modIds
     */
    private function inLayout(LayoutModel $layout, array $modIds): bool
    {
        foreach (StringUtil::deserialize($layout->modules, true) as $row) {
            if (isset($row['mod']) && \in_array((int) $row['mod'], $modIds, true)) {
                return true;
            }
        }

        return false;
    }
}
