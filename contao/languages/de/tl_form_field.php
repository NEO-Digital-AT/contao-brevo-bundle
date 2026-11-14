<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Brevo-Anmeldung';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Feld-Zuordnung';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Checkbox-Text', 'Sichtbarer Text neben der Opt-in-Checkbox (z. B. „Newsletter abonnieren – jederzeit abbestellbar.“).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Brevo-Verteiler', 'In diese Liste(n) wird der Kontakt nach der Bestätigung eingetragen (live aus dem Brevo-Konto).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Double-Opt-in-Vorlage', 'Brevo-Vorlage der Bestätigungs-E-Mail (live aus dem Brevo-Konto).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Bestätigungsseite', 'Auf diese Seite führt der Bestätigungs-Link in der Double-Opt-in-E-Mail.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['E-Mail-Feld', 'Welches Formularfeld liefert die E-Mail-Adresse?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Vorname-Feld (optional)', 'Welches Formularfeld liefert den Vornamen? Wird als Kontakt-Attribut mitgesendet.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Nachname-Feld (optional)', 'Welches Formularfeld liefert den Nachnamen? Wird als Kontakt-Attribut mitgesendet.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Noch kein Brevo-API-Schlüssel unter „Zugänge und Lizenzen“: Listen und Vorlagen des Kontos können nicht geladen werden. Eine früher gespeicherte Auswahl bleibt erhalten.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo liefert zum gespeicherten Schlüssel keine Listen (Schlüssel falsch oder Brevo nicht erreichbar): Es gibt nichts zu wählen. Eine früher gespeicherte Auswahl bleibt erhalten.';
