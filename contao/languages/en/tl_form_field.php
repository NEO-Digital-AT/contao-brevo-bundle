<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Brevo sign-up';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Field mapping';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Checkbox text', 'Visible text next to the opt-in checkbox.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Brevo list(s)', 'The confirmed contact is added to these list(s) (live from the Brevo account).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Double opt-in template', 'Brevo template of the confirmation e-mail (live from the Brevo account).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Confirmation page', 'The confirmation link in the double opt-in e-mail leads to this page.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['E-mail field', 'Which form field provides the e-mail address?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['First name field (optional)', 'Which form field provides the first name? Sent as a contact attribute.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Last name field (optional)', 'Which form field provides the last name? Sent as a contact attribute.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'No Brevo API key on “Access keys and licences” yet: the lists and templates of the account cannot be loaded. A choice stored earlier is kept.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo gives no lists for the stored key (key wrong or Brevo not reachable): there is nothing to choose. A choice stored earlier is kept.';
