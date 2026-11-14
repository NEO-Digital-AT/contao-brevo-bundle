<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Popisi';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Dvostruka potvrda';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Obrazac';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Uvod', 'Neobavezni tekst iznad obrasca.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Popis(i) kontakata', 'Brevo popisi na koje se kontakt dodaje. Potreban je Brevo API ključ pod „Pristupi i licence”.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Način rada', 'Fiksno: uvijek odabrani popisi. Izbor: posjetitelj sam bira na stranici.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Fiksno – uvijek odabrani popisi',
    'choice' => 'Izbor – posjetitelj bira na stranici',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Vrsta izbora', 'Jedan izbor (padajući izbornik) ili više izbora (kućice).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Jedan izbor (padajući izbornik)',
    'multiple' => 'Više izbora (kućice)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Prikazani nazivi (neobavezno)', 'Vlastiti naziv za svaki popis: ključ = ID Brevo popisa, vrijednost = prikazani naziv. Prazno = naziv iz Brevoa.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['DOI predložak', 'Predložak dvostruke potvrde iz vašeg Brevo računa (izravan odabir). Brevo njime šalje e-mail za potvrdu.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Stranica potvrde', 'Stranica na koju se korisnik preusmjerava nakon klika na poveznicu u e-mailu za potvrdu.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Oznaka polja za e-mail', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Tekst gumba', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Tekst privole', 'Obavezna kućica (GDPR). Dopuštene su insert-oznake, npr. {{link::privacy::Politika privatnosti}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Poruka o uspjehu', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Poruke';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Oznaka izbora popisa', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Poruka: neispravna e-mail adresa', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Poruka: nije odabran popis', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Poruka: previše pokušaja', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Poruka: ostale pogreške', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Ovo proširenje je besplatno. Uvjet: impresum svakog web-mjesta na kojem javno radi navodi ga s poveznicom na https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Tekst za kopiranje (s poveznicom):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Prijava na newsletter: Contao Brevo Newsletter tvrtke NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Ili kao HTML za izvorni kod impresuma:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licenca';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Još nema Brevo API ključa pod „Pristupi i licence”: popisi i predlošci računa ne mogu se učitati. Prije spremljeni odabir ostaje.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo za spremljeni ključ ne vraća popise (pogrešan ključ ili Brevo nedostupan): nema se što odabrati. Prije spremljeni odabir ostaje.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Vrijedi samo u načinu „Izbor”.';
