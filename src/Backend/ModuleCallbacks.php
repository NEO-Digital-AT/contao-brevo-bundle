<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Backend;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Shows the default texts as placeholders of the module fields, so editors see
 * what an empty field displays (in the back-end language; on the page the
 * default comes in the page language).
 */
final class ModuleCallbacks
{
    private const DEFAULTS = [
        'brevo_email_label' => 'email_label',
        'brevo_button' => 'button',
        'brevo_success' => 'success',
        'brevo_lists_label' => 'lists_legend',
        'brevo_error_invalid' => 'error_invalid',
        'brevo_error_choose' => 'error_choose',
        'brevo_error_limit' => 'error_limit',
        'brevo_error_generic' => 'error_generic',
    ];

    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function placeholders(): void
    {
        foreach (self::DEFAULTS as $field => $key) {
            if (isset($GLOBALS['TL_DCA']['tl_module']['fields'][$field])) {
                $GLOBALS['TL_DCA']['tl_module']['fields'][$field]['eval']['placeholder'] = $this->translator->trans('form.'.$key, [], 'neo_brevo');
            }
        }
    }
}
