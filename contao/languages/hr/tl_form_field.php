<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Brevo prijava';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Povezivanje polja';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Tekst uz kućicu', 'Vidljivi tekst pokraj kućice za privolu.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Brevo popis(i)', 'Potvrđeni kontakt dodaje se na ove popise (izravno iz Brevo računa).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Predložak dvostruke potvrde', 'Brevo predložak e-maila za potvrdu (izravno iz Brevo računa).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Stranica potvrde', 'Poveznica za potvrdu u e-mailu dvostruke potvrde vodi na ovu stranicu.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['Polje za e-mail', 'Koje polje obrasca sadrži e-mail adresu?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Polje za ime (neobavezno)', 'Koje polje obrasca sadrži ime? Šalje se kao atribut kontakta.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Polje za prezime (neobavezno)', 'Koje polje obrasca sadrži prezime? Šalje se kao atribut kontakta.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Još nema Brevo API ključa pod „Pristupi i licence”: popisi i predlošci računa ne mogu se učitati. Prije spremljeni odabir ostaje.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo za spremljeni ključ ne vraća popise (pogrešan ključ ili Brevo nedostupan): nema se što odabrati. Prije spremljeni odabir ostaje.';
