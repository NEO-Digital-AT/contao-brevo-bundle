<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Backend;

use Contao\DataContainer;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Lists and the double opt-in template come live from the Brevo account.
 * Without a key, or when Brevo gives none for the stored key, there is nothing
 * to choose: the fields are disabled with the reason at the field (FieldLock),
 * a choice stored earlier stays and the rest of the form can be saved. The
 * label of the list choice is only used when visitors choose their lists.
 */
final class DependencyCallbacks
{
    /** Table => type of the records. */
    private const TYPES = [
        'tl_module' => 'brevo_newsletter',
        'tl_form_field' => 'brevo_optin',
    ];

    public function __construct(
        private readonly ApiKeyResolver $apiKeys,
        private readonly BrevoClient $brevo,
        private readonly Connection $db,
        private readonly RequestStack $requestStack,
    ) {
    }

    /** onload_callback of tl_module and tl_form_field. */
    public function lock(DataContainer $dc): void
    {
        $type = self::TYPES[$dc->table] ?? null;

        // Only the edit form of one record (in the list view $dc->id is the parent).
        if (null === $type || 'edit' !== $this->requestStack->getCurrentRequest()?->query->get('act') || !$dc->id) {
            return;
        }

        $row = $this->db->fetchAssociative('SELECT * FROM '.$dc->table.' WHERE id = ?', [(int) $dc->id]);

        if (false === $row || $type !== $row['type']) {
            return;
        }

        $lang = $GLOBALS['TL_LANG'][$dc->table] ?? [];
        $key = $this->apiKeys->resolve();

        if ('' === $key) {
            $reason = $lang['brevo_locked_no_key'] ?? '';
        } elseif ([] === $this->brevo->getLists($key)) {
            $reason = $lang['brevo_locked_no_answer'] ?? '';
        } else {
            $reason = '';
        }

        if ('' !== $reason) {
            FieldLock::lock($dc->table, 'brevo_lists', $reason);
            FieldLock::lock($dc->table, 'brevo_doi_template', $reason);
            // Without an answer from Brevo the stored choice is shown by its id, not as empty.
            $this->storedAsOptions($dc->table, 'brevo_lists', array_map('intval', StringUtil::deserialize($row['brevo_lists'] ?? null, true)));
            $this->storedAsOptions($dc->table, 'brevo_doi_template', [(int) ($row['brevo_doi_template'] ?? 0)]);

            // The name attributes come from the account too; "automatic" still works.
            foreach (['brevo_attr_firstname', 'brevo_attr_lastname'] as $field) {
                if ('tl_module' === $dc->table && isset($GLOBALS['TL_DCA'][$dc->table]['fields'][$field])) {
                    FieldLock::lock($dc->table, $field, $reason);
                    $stored = trim((string) ($row[$field] ?? ''));
                    unset($GLOBALS['TL_DCA'][$dc->table]['fields'][$field]['options_callback']);
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$field]['options'] = '' === $stored ? [] : [$stored => $stored];
                }
            }
        }

        if ('tl_module' === $dc->table && 'choice' !== (string) $row['brevo_mode']) {
            FieldLock::lock($dc->table, 'brevo_lists_label', $lang['brevo_locked_choice'] ?? '');
        }

        // The name attributes only matter when the name fields are shown.
        if ('tl_module' === $dc->table) {
            $fields = array_map('strval', StringUtil::deserialize($row['brevo_fields'] ?? null, true));

            foreach (['firstname' => 'brevo_attr_firstname', 'lastname' => 'brevo_attr_lastname'] as $key => $field) {
                if (!\in_array($key, $fields, true) && isset($GLOBALS['TL_DCA'][$dc->table]['fields'][$field])) {
                    FieldLock::lock($dc->table, $field, $lang['brevo_locked_field'] ?? '');
                }
            }
        }
    }

    /**
     * @param list<int> $ids
     */
    private function storedAsOptions(string $table, string $field, array $ids): void
    {
        $options = [];

        foreach (array_filter($ids) as $id) {
            $options[$id] = '#'.$id;
        }

        unset($GLOBALS['TL_DCA'][$table]['fields'][$field]['options_callback']);
        $GLOBALS['TL_DCA'][$table]['fields'][$field]['options'] = $options;
    }
}
