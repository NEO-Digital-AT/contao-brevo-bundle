<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Lists';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Double opt-in';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Form';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Intro', 'Optional text shown above the form.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Contact list(s)', 'Brevo lists the contact is added to. Requires the Brevo API key on "Access keys and licences".'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Mode', 'Fixed: always the selected lists. Choice: the visitor picks in the front end.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Fixed – always the selected lists',
    'choice' => 'Choice – visitor picks in the front end',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Choice type', 'Single choice (select box) or multiple choice (checkboxes).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Single choice (select box)',
    'multiple' => 'Multiple choice (checkboxes)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Display names (optional)', 'Custom label per list: key = Brevo list id, value = display name. Empty = Brevo name.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['DOI template', 'Double-opt-in template from your Brevo account (live picker). Brevo sends the confirmation mail with it.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Confirmation page', 'Page the user is redirected to after clicking the link in the confirmation e-mail.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['E-mail field label', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Button text', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Consent text', 'Mandatory checkbox (GDPR). Insert tags allowed, e.g. {{link::privacy::Privacy policy}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Success message', 'Empty = default (shown in grey), on the page in its language.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Messages';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Label of the list choice', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Message: invalid e-mail address', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Message: no list chosen', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Message: too many attempts', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Message: other error', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'This extension is free. Condition: the legal notice of every website on which it runs publicly names it with a link to https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Text to copy (with link):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Newsletter sign-up: Contao Brevo Newsletter by NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Or as HTML for the source code of the legal notice:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licence';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'No Brevo API key on “Access keys and licences” yet: the lists and templates of the account cannot be loaded. A choice stored earlier is kept.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo gives no lists for the stored key (key wrong or Brevo not reachable): there is nothing to choose. A choice stored earlier is kept.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Only used with the mode “Choice”.';
