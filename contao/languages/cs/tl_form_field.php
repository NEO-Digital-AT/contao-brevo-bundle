<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Přihlášení do Brevo';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Přiřazení polí';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Text u zaškrtávacího políčka', 'Viditelný text vedle políčka pro souhlas.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Seznam(y) v Brevo', 'Potvrzený kontakt se přidá do těchto seznamů (načítáno přímo z účtu Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Šablona dvojitého potvrzení', 'Šablona potvrzovacího e-mailu v Brevo (načítáno přímo z účtu Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Potvrzovací stránka', 'Na tuto stránku vede potvrzovací odkaz v e-mailu s dvojitým potvrzením.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['Pole pro e-mail', 'Které pole formuláře obsahuje e-mailovou adresu?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Pole pro jméno (nepovinné)', 'Které pole formuláře obsahuje křestní jméno? Odešle se jako atribut kontaktu.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Pole pro příjmení (nepovinné)', 'Které pole formuláře obsahuje příjmení? Odešle se jako atribut kontaktu.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Zatím žádný klíč API Brevo v „Přístupy a licence“: seznamy a šablony účtu nelze načíst. Dříve uložená volba zůstane zachována.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo k uloženému klíči nevrací žádné seznamy (chybný klíč nebo Brevo nedostupné): není co vybrat. Dříve uložená volba zůstane zachována.';
