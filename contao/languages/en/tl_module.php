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

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Text';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'Additional fields';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'Field labels';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Spam protection';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['Additional fields', 'Stored with the contact in Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Required fields', 'Without these the sign-up is refused. Only fields that are shown count.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'First name',
    'lastname' => 'Last name',
    'sms' => 'Mobile number (Brevo: SMS)',
    'landline' => 'Landline (Brevo: LANDLINE_NUMBER)',
    'job_title' => 'Job title (Brevo: JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Brevo attribute for the first name', 'Automatic = the default attribute of the account (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Brevo attribute for the last name', 'Automatic = the default attribute of the account (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Automatic';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Label: first name', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Label: last name', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Label: mobile number', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Label: landline', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Label: job title', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Message: required field empty', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Message: phone number not international', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Message: address already signed up', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Message: security check failed', 'Empty = default (shown in grey), on the page in its language.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Sign-ups per hour', 'Confirmation e-mails an hour for all visitors together. 0 = no limit.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Sign-ups per day', 'Confirmation e-mails a day for all visitors together. 0 = no limit.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Built in and always on: an invisible task that the visitor’s browser solves while the address is typed (ALTCHA method, no cookies, nothing for the visitor to click), a hidden field against bots, refusal of requests from other websites and from scripts, one confirmation e-mail per address in 24 hours, at most 2 sign-ups per visitor an hour and 3 a day. Below: the limit for all visitors together. It stops bots that change their IP address; when it is reached, the system log says so.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Only used when this name field is shown.';
