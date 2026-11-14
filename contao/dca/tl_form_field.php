<?php

declare(strict_types=1);

use Contao\DataContainer;
use Contao\FormFieldModel;
use Contao\System;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;

/*
 * Form generator field "Brevo sign-up" (brevo_optin): an opt-in checkbox the
 * editor can drop into ANY form. On submit, BrevoOptinFormListener subscribes
 * the address via double opt-in — which form fields supply e-mail/first/last
 * name and which Brevo list(s) the contact goes into is set per field here
 * (lists/DOI templates live from the API, field mapping as a choice of the
 * sibling fields — no free text).
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['brevo_optin'] =
    '{type_legend},type,name,label;'
    .'{brevo_legend},brevo_optin_label,brevo_lists,brevo_doi_template,brevo_redirect;'
    .'{fields_legend},brevo_email_field,brevo_firstname_field,brevo_lastname_field;'
    .'{expert_legend:hide},class,accesskey,tabindex;'
    .'{invisible_legend:hide},invisible';

// Visible text next to the checkbox.
$GLOBALS['TL_DCA']['tl_form_field']['fields']['brevo_optin_label'] = [
    'inputType' => 'text',
    'exclude' => true,
    'eval' => ['maxlength' => 255, 'mandatory' => true, 'tl_class' => 'long clr'],
    'sql' => "varchar(255) NOT NULL default ''",
];

// Target list(s) — live from the Brevo account (as in the newsletter module).
$GLOBALS['TL_DCA']['tl_form_field']['fields']['brevo_lists'] = [
    'inputType' => 'checkbox',
    'exclude' => true,
    'eval' => ['multiple' => true, 'mandatory' => true, 'tl_class' => 'clr'],
    'options_callback' => static fn (): array => System::getContainer()
        ->get(BrevoClient::class)
        ->getLists(System::getContainer()->get(ApiKeyResolver::class)->resolve()),
    'sql' => 'blob NULL',
];

// Double opt-in template — live from the Brevo account.
$GLOBALS['TL_DCA']['tl_form_field']['fields']['brevo_doi_template'] = [
    'inputType' => 'select',
    'exclude' => true,
    'options_callback' => static fn (): array => System::getContainer()
        ->get(BrevoClient::class)
        ->getTemplates(System::getContainer()->get(ApiKeyResolver::class)->resolve()),
    'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => 'int(10) unsigned NOT NULL default 0',
];

// Page the confirmation link in the DOI e-mail leads to.
$GLOBALS['TL_DCA']['tl_form_field']['fields']['brevo_redirect'] = [
    'inputType' => 'pageTree',
    'exclude' => true,
    'eval' => ['mandatory' => true, 'fieldType' => 'radio', 'tl_class' => 'w50'],
    'sql' => 'int(10) unsigned NOT NULL default 0',
];

/*
 * Field mapping: a choice of the sibling fields of THIS form (only fields with
 * a name, no checkboxes/buttons) — editors never type field names by hand.
 */
$brevoFormFieldOptions = static function (DataContainer $dc): array {
    $pid = (int) ($dc->getCurrentRecord()['pid'] ?? 0);

    if ($pid < 1) {
        return [];
    }

    $rows = FormFieldModel::findBy(
        ["tl_form_field.pid = ? AND tl_form_field.name != '' AND tl_form_field.type IN ('text', 'textarea', 'hidden')"],
        [$pid],
        ['order' => 'tl_form_field.sorting'],
    );

    $options = [];

    foreach ($rows ?? [] as $row) {
        $label = trim((string) $row->label);
        $options[$row->name] = '' !== $label ? $row->name.' — '.$label : $row->name;
    }

    return $options;
};

$GLOBALS['TL_DCA']['tl_form_field']['fields']['brevo_email_field'] = [
    'inputType' => 'select',
    'exclude' => true,
    'options_callback' => $brevoFormFieldOptions,
    'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50 clr'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['brevo_firstname_field'] = [
    'inputType' => 'select',
    'exclude' => true,
    'options_callback' => $brevoFormFieldOptions,
    'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['brevo_lastname_field'] = [
    'inputType' => 'select',
    'exclude' => true,
    'options_callback' => $brevoFormFieldOptions,
    'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

// Message at the top of the field while no API key is stored.
$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = [\Neo\BrevoNewsletterBundle\Backend\KeyWarning::class, 'add'];
// Lists and template without a key or answer from Brevo: disabled, the reason at the field.
$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = [\Neo\BrevoNewsletterBundle\Backend\DependencyCallbacks::class, 'lock'];
