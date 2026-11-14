<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Iscrizione Brevo';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Assegnazione dei campi';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Testo della casella', 'Testo visibile accanto alla casella di consenso.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Liste Brevo', 'Il contatto confermato viene aggiunto a queste liste (caricate in tempo reale dall’account Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Modello doppio opt-in', 'Modello Brevo dell’e-mail di conferma (caricato in tempo reale dall’account Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Pagina di conferma', 'Il link di conferma nell’e-mail di doppio opt-in porta a questa pagina.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['Campo e-mail', 'Quale campo del modulo contiene l’indirizzo e-mail?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Campo nome (facoltativo)', 'Quale campo del modulo contiene il nome? Viene trasmesso come attributo del contatto.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Campo cognome (facoltativo)', 'Quale campo del modulo contiene il cognome? Viene trasmesso come attributo del contatto.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Ancora nessuna chiave API Brevo in «Accessi e licenze»: liste e modelli dell’account non si possono caricare. Una scelta salvata in precedenza resta.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo non restituisce liste per la chiave salvata (chiave errata o Brevo non raggiungibile): non c’è nulla da scegliere. Una scelta salvata in precedenza resta.';
