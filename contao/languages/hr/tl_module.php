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

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Tekst';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'Dodatna polja';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'Oznake polja';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Zaštita od neželjene pošte';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['Dodatna polja', 'Spremaju se uz kontakt u Brevu.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Obavezna polja', 'Bez ovih podataka prijava se odbija. Računaju se samo prikazana polja.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'Ime',
    'lastname' => 'Prezime',
    'sms' => 'Broj mobitela (Brevo: SMS)',
    'landline' => 'Fiksni telefon (Brevo: LANDLINE_NUMBER)',
    'job_title' => 'Radno mjesto (Brevo: JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Atribut Breva za ime', 'Automatski = zadani atribut računa (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Atribut Breva za prezime', 'Automatski = zadani atribut računa (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Automatski';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Oznaka: ime', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Oznaka: prezime', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Oznaka: broj mobitela', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Oznaka: fiksni telefon', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Oznaka: radno mjesto', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Poruka: obavezno polje prazno', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Poruka: broj nije u međunarodnom formatu', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Poruka: adresa je već prijavljena', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Poruka: sigurnosna provjera nije uspjela', 'Prazno = zadani tekst (prikazan sivo), na stranici na njezinu jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Prijava po satu', 'E-poruke za potvrdu po satu za sve posjetitelje zajedno. 0 = bez ograničenja.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Prijava po danu', 'E-poruke za potvrdu po danu za sve posjetitelje zajedno. 0 = bez ograničenja.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Ugrađeno i uvijek uključeno: nevidljivi zadatak koji preglednik posjetitelja rješava dok upisuje adresu (metoda ALTCHA, bez kolačića, posjetitelj ništa ne klikće), skriveno polje protiv botova, odbijanje zahtjeva s drugih web-mjesta i iz skripti, jedna e-poruka za potvrdu po adresi u 24 sata, najviše 2 prijave po posjetitelju na sat i 3 na dan. Ispod: ograničenje za sve posjetitelje zajedno. Zaustavlja botove koji mijenjaju IP adresu; kad se dosegne, to piše u zapisniku sustava.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Koristi se samo kad se prikazuje ovo polje imena.';
