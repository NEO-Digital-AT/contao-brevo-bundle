<?php

declare(strict_types=1);

use Contao\System;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;

/*
 * Back-end palette for the "brevo_newsletter" FRONTEND MODULE
 * (Neo\BrevoNewsletterBundle\Controller\FrontendModule\NewsletterModuleController).
 *
 * Per-module configuration (one shared API key on "Access keys and licences"
 * of the Basic bundle):
 *  - pick the target Brevo list(s) from the account's live lists;
 *  - "fixed": the contact always goes to all picked lists;
 *  - "choice": the visitor picks from them (single select or checkboxes), with
 *    optional per-list label overrides;
 *  - pick the double-opt-in template from the account's live templates and the
 *    confirmation redirect page; every visible string is editable.
 * Place the module in a page via the standard "Module" content element.
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'brevo_mode';

$GLOBALS['TL_DCA']['tl_module']['palettes']['brevo_newsletter'] =
    '{licence_legend},brevo_licence_note;{title_legend},name,headline,type;'
    .'{text_legend},brevo_intro;'
    .'{lists_legend},brevo_lists,brevo_mode;'
    .'{doi_legend},brevo_doi_template,brevo_redirect;'
    .'{form_legend},brevo_email_label,brevo_button,brevo_consent,brevo_success;'
    // Every visible text per module, so any language works without a translation file.
    .'{messages_legend:hide},brevo_lists_label,brevo_error_invalid,brevo_error_choose,brevo_error_limit,brevo_error_generic;'
    .'{template_legend:hide},customTpl;'
    .'{protected_legend:hide},protected;'
    .'{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['brevo_mode_choice'] = 'brevo_choice_type,brevo_list_labels';

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_intro'] = [
    'inputType' => 'textarea',
    'exclude' => true,
    'eval' => ['rows' => 3, 'tl_class' => 'clr'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_lists'] = [
    'inputType' => 'checkbox',
    'exclude' => true,
    'eval' => ['multiple' => true, 'mandatory' => true, 'tl_class' => 'clr'],
    'options_callback' => static fn (): array => System::getContainer()
        ->get(BrevoClient::class)
        ->getLists(System::getContainer()->get(ApiKeyResolver::class)->resolve()),
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_mode'] = [
    'inputType' => 'select',
    'exclude' => true,
    'options' => ['fixed', 'choice'],
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'],
    'eval' => ['submitOnChange' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(8) NOT NULL default 'fixed'",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_choice_type'] = [
    'inputType' => 'select',
    'exclude' => true,
    'options' => ['single', 'multiple'],
    'reference' => &$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(8) NOT NULL default 'single'",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_list_labels'] = [
    'inputType' => 'keyValueWizard',
    'exclude' => true,
    'eval' => ['tl_class' => 'clr'],
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_doi_template'] = [
    'inputType' => 'select',
    'exclude' => true,
    'options_callback' => static fn (): array => System::getContainer()
        ->get(BrevoClient::class)
        ->getTemplates(System::getContainer()->get(ApiKeyResolver::class)->resolve()),
    'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "int(10) unsigned NOT NULL default 0",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_redirect'] = [
    'inputType' => 'pageTree',
    'exclude' => true,
    'eval' => ['mandatory' => true, 'fieldType' => 'radio', 'tl_class' => 'w50'],
    'sql' => "int(10) unsigned NOT NULL default 0",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_email_label'] = [
    'inputType' => 'text',
    'exclude' => true,
    'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_button'] = [
    'inputType' => 'text',
    'exclude' => true,
    'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_consent'] = [
    'inputType' => 'textarea',
    'exclude' => true,
    'eval' => ['mandatory' => true, 'rows' => 2, 'tl_class' => 'clr', 'decodeEntities' => true],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_success'] = [
    'inputType' => 'text',
    'exclude' => true,
    'eval' => ['maxlength' => 255, 'tl_class' => 'long clr'],
    'sql' => "varchar(255) NOT NULL default ''",
];

// Messages and the list label: empty = default in the page language (shown as placeholder).
foreach (['brevo_lists_label', 'brevo_error_invalid', 'brevo_error_choose', 'brevo_error_limit', 'brevo_error_generic'] as $field) {
    $GLOBALS['TL_DCA']['tl_module']['fields'][$field] = [
        'inputType' => 'text',
        'exclude' => true,
        'eval' => ['maxlength' => 255, 'decodeEntities' => true, 'tl_class' => 'brevo_lists_label' === $field ? 'w50' : 'long clr'],
        'sql' => 'text NULL',
    ];
}

$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = [\Neo\BrevoNewsletterBundle\Backend\ModuleCallbacks::class, 'placeholders'];
$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = [\Neo\BrevoNewsletterBundle\Backend\KeyWarning::class, 'add'];
// Lists and template without a key or answer from Brevo: disabled, the reason at the field.
$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = [\Neo\BrevoNewsletterBundle\Backend\DependencyCallbacks::class, 'lock'];

// Condition of the free licence with an example for the legal notice, first in the form.
$GLOBALS['TL_DCA']['tl_module']['fields']['brevo_licence_note'] = [
    'input_field_callback' => static fn (): string => Neo\BrevoNewsletterBundle\Backend\CreditNote::forTable('tl_module', 'brevo_licence_'),
];
