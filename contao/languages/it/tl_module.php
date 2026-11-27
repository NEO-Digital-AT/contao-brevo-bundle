<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Liste';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Doppio opt-in';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Modulo';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Introduzione', 'Testo facoltativo mostrato sopra il modulo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Liste di contatti', 'Liste Brevo a cui viene aggiunto il contatto. Richiede la chiave API Brevo in «Accessi e licenze».'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Modalità', 'Fissa: sempre le liste selezionate. A scelta: decide il visitatore sul sito.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Fissa – sempre le liste selezionate',
    'choice' => 'A scelta – decide il visitatore sul sito',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Tipo di scelta', 'Scelta singola (menu a tendina) o multipla (caselle di controllo).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Scelta singola (menu a tendina)',
    'multiple' => 'Scelta multipla (caselle di controllo)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Nomi visualizzati (facoltativo)', 'Etichetta personalizzata per ogni lista: chiave = ID della lista Brevo, valore = nome visualizzato. Vuoto = nome in Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['Modello DOI', 'Modello di doppio opt-in del Suo account Brevo (selezione in tempo reale). Brevo lo usa per inviare l’e-mail di conferma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Pagina di conferma', 'Pagina a cui viene indirizzato l’utente dopo aver cliccato il link nell’e-mail di conferma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Etichetta del campo e-mail', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Testo del pulsante', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Testo del consenso', 'Casella obbligatoria (GDPR). Sono ammessi gli insert tag, ad es. {{link::privacy::Informativa sulla privacy}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Messaggio di conferma', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Messaggi';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Etichetta della scelta delle liste', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Messaggio: indirizzo e-mail non valido', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Messaggio: nessuna lista scelta', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Messaggio: troppi tentativi', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Messaggio: altro errore', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Questa estensione è gratuita. Condizione: le note legali di ogni sito su cui è in uso pubblicamente la citano con un link a https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Testo da copiare (con link):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Iscrizione alla newsletter: Contao Brevo Newsletter di NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Oppure in HTML per il codice sorgente delle note legali:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licenza';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Ancora nessuna chiave API Brevo in «Accessi e licenze»: liste e modelli dell’account non si possono caricare. Una scelta salvata in precedenza resta.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo non restituisce liste per la chiave salvata (chiave errata o Brevo non raggiungibile): non c’è nulla da scegliere. Una scelta salvata in precedenza resta.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Vale solo con la modalità «A scelta».';

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Testo';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'Campi aggiuntivi';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'Etichette dei campi';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Protezione antispam';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['Campi aggiuntivi', 'Salvati con il contatto in Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Campi obbligatori', 'Senza questi dati l’iscrizione viene rifiutata. Contano solo i campi mostrati.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'Nome',
    'lastname' => 'Cognome',
    'sms' => 'Numero di cellulare (Brevo: SMS)',
    'landline' => 'Telefono fisso (Brevo: LANDLINE_NUMBER)',
    'job_title' => 'Ruolo (Brevo: JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Attributo Brevo per il nome', 'Automatico = l’attributo predefinito dell’account (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Attributo Brevo per il cognome', 'Automatico = l’attributo predefinito dell’account (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Automatico';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Etichetta: nome', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Etichetta: cognome', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Etichetta: numero di cellulare', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Etichetta: telefono fisso', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Etichetta: ruolo', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Messaggio: campo obbligatorio vuoto', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Messaggio: numero non in formato internazionale', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Messaggio: indirizzo già iscritto', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Messaggio: controllo di sicurezza fallito', 'Vuoto = testo predefinito (mostrato in grigio), sul sito nella lingua della pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Iscrizioni all’ora', 'E-mail di conferma all’ora per tutti i visitatori insieme. 0 = nessun limite.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Iscrizioni al giorno', 'E-mail di conferma al giorno per tutti i visitatori insieme. 0 = nessun limite.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Integrata e sempre attiva: un compito invisibile che il browser del visitatore risolve mentre digita l’indirizzo (metodo ALTCHA, senza cookie, il visitatore non deve cliccare nulla), un campo nascosto contro i bot, il rifiuto delle richieste da altri siti e da script, un’e-mail di conferma per indirizzo ogni 24 ore, al massimo 2 iscrizioni per visitatore all’ora e 3 al giorno. Sotto: il limite per tutti i visitatori insieme. Ferma i bot che cambiano indirizzo IP; quando viene raggiunto, lo indica il registro di sistema.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Usato solo quando questo campo del nome è mostrato.';
