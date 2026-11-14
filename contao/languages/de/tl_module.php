<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Verteiler';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Double-Opt-In';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Formular';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Einleitung', 'Optionaler Text über dem Formular.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Verteilerliste(n)', 'Brevo-Listen, in die der Kontakt eingetragen wird. Erfordert den Brevo-API-Schlüssel unter „Zugänge und Lizenzen“.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Modus', 'Fix: immer in die gewählten Listen. Auswahl: der Besucher wählt im Frontend.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Fix – immer in die gewählten Listen',
    'choice' => 'Auswahl – Besucher wählt im Frontend',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Auswahltyp', 'Einfachauswahl (Selectbox) oder Mehrfachauswahl (Checkboxen).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Einfachauswahl (Selectbox)',
    'multiple' => 'Mehrfachauswahl (Checkboxen)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Anzeigenamen (optional)', 'Eigene Bezeichnung je Liste: Schlüssel = Brevo-Listen-ID, Wert = Anzeigename. Leer = Brevo-Name.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['DOI-Vorlage', 'Double-Opt-in-Vorlage aus Ihrem Brevo-Konto (Auswahl direkt aus dem Konto). Brevo verschickt damit die Bestätigungsmail.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Bestätigungsseite', 'Seite, auf die nach dem Klick in der Bestätigungsmail weitergeleitet wird.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Label E-Mail-Feld', 'Leer = Vorgabe (grau angezeigt), auf der Seite in deren Sprache.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Button-Text', 'Leer = Vorgabe (grau angezeigt), auf der Seite in deren Sprache.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Einwilligungstext', 'Pflicht-Häkchen (DSGVO). Insert-Tags erlaubt, z. B. {{link::datenschutz::Datenschutzerklärung}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Erfolgsmeldung', 'Leer = Vorgabe (grau angezeigt), auf der Seite in deren Sprache.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Meldungen';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Beschriftung der Verteiler-Auswahl', 'Leer = Vorgabe (grau angezeigt), auf der Seite in deren Sprache.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Meldung: ungültige E-Mail-Adresse', 'Leer = Vorgabe (grau angezeigt), auf der Seite in deren Sprache.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Meldung: keine Liste gewählt', 'Leer = Vorgabe (grau angezeigt), auf der Seite in deren Sprache.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Meldung: zu viele Versuche', 'Leer = Vorgabe (grau angezeigt), auf der Seite in deren Sprache.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Meldung: sonstiger Fehler', 'Leer = Vorgabe (grau angezeigt), auf der Seite in deren Sprache.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Diese Erweiterung ist kostenlos. Bedingung: Im Impressum jeder Website, auf der sie öffentlich läuft, wird sie mit einem Link auf https://neo-digital.at genannt.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Text zum Kopieren (mit Link):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Newsletter-Anmeldung: Contao Brevo Newsletter von NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Oder als HTML für den Quelltext des Impressums:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Lizenz';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Noch kein Brevo-API-Schlüssel unter „Zugänge und Lizenzen“: Listen und Vorlagen des Kontos können nicht geladen werden. Eine früher gespeicherte Auswahl bleibt erhalten.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo liefert zum gespeicherten Schlüssel keine Listen (Schlüssel falsch oder Brevo nicht erreichbar): Es gibt nichts zu wählen. Eine früher gespeicherte Auswahl bleibt erhalten.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Wirkt nur im Modus „Auswahl“.';
