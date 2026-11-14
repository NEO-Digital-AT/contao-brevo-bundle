<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Widget;

use Contao\FormCheckbox;

/**
 * Form generator field "Brevo sign-up": a single opt-in checkbox.
 * Inherits everything from Contao's FormCheckbox (markup, template
 * form_checkbox, hidden fallback, error handling) — the only difference: the
 * single option is fixed (value '1') and its visible text comes from
 * brevo_optin_label. The sign-up itself is done by BrevoOptinFormListener on
 * submit.
 */
class FormBrevoOptin extends FormCheckbox
{
    public function __construct($arrAttributes = null)
    {
        parent::__construct($arrAttributes);

        $this->arrOptions = [[
            'value' => '1',
            'label' => (string) $this->brevo_optin_label,
        ]];
    }
}
