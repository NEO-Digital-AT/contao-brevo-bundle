<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Backend;

use Contao\DataContainer;
use Contao\System;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Access\AccessPage;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;

/**
 * Message at the top of a Brevo front-end module or a "Brevo sign-up" form field
 * while no API key is stored: lists and templates cannot be chosen and the
 * sign-up does not work. Links to the section on "Access keys and licences"
 * (Basic bundle) for users who may open it. Text: TL_LANG.tl_neo_access of this
 * bundle.
 */
final class KeyWarning
{
    /** Table => type of the records the message is shown for. */
    private const TYPES = [
        'tl_module' => 'brevo_newsletter',
        'tl_form_field' => 'brevo_optin',
    ];

    public function __construct(
        private readonly ApiKeyResolver $apiKeys,
        private readonly Connection $db,
        private readonly RequestInput $input,
    ) {
    }

    public function add(DataContainer $dc): void
    {
        $type = self::TYPES[$dc->table] ?? null;

        if (null === $type || 'edit' !== $this->input->query('act') || '' !== $this->apiKeys->resolve()) {
            return;
        }

        if ($type !== $this->db->fetchOne('SELECT type FROM '.$dc->table.' WHERE id = ?', [(int) $dc->id])) {
            return;
        }

        System::loadLanguageFile(AccessPage::TABLE);
        AccessPage::addMissingMessage($GLOBALS['TL_LANG'][AccessPage::TABLE]['brevo_missing'] ?? '', ApiKeyResolver::LEGEND);
    }
}
