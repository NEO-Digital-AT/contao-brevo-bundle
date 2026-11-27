<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Listák';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Dupla megerősítés';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Űrlap';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Bevezető', 'Opcionális szöveg az űrlap felett.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Kapcsolati lista/listák', 'Brevo-listák, amelyekre a kapcsolat felkerül. A Brevo API-kulcs szükséges a „Hozzáférések és licencek” oldalon.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Mód', 'Rögzített: mindig a kiválasztott listák. Választható: a látogató választ a weboldalon.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Rögzített – mindig a kiválasztott listák',
    'choice' => 'Választható – a látogató választ a weboldalon',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Választás típusa', 'Egyszeres választás (legördülő lista) vagy többszörös választás (jelölőnégyzetek).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Egyszeres választás (legördülő lista)',
    'multiple' => 'Többszörös választás (jelölőnégyzetek)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Megjelenített nevek (nem kötelező)', 'Egyéni felirat listánként: kulcs = Brevo-lista azonosítója, érték = megjelenített név. Üres = a Brevóban használt név.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['DOI-sablon', 'Dupla megerősítési sablon a Brevo-fiókjából (élő választó). A Brevo ezzel küldi el a megerősítő e-mailt.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Megerősítő oldal', 'Az az oldal, ahová a felhasználó a megerősítő e-mailben lévő hivatkozásra kattintás után kerül.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Az e-mail mező felirata', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Gomb szövege', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Hozzájárulási szöveg', 'Kötelező jelölőnégyzet (GDPR). Insert tagek használhatók, pl. {{link::privacy::Adatvédelmi tájékoztató}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Sikerüzenet', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Üzenetek';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['A listaválasztás felirata', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Üzenet: érvénytelen e-mail-cím', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Üzenet: nincs kiválasztott lista', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Üzenet: túl sok próbálkozás', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Üzenet: egyéb hiba', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Ez a bővítmény ingyenes. Feltétel: minden olyan weboldal impresszuma, amelyen nyilvánosan fut, megnevezi egy https://neo-digital.at címre mutató hivatkozással.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Másolható szöveg (hivatkozással):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Hírlevél-feliratkozás: Contao Brevo Newsletter, készítette: NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Vagy HTML-ként az impresszum forráskódjához:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licenc';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Még nincs Brevo API-kulcs a „Hozzáférések és licencek” oldalon: a fiók listái és sablonjai nem tölthetők be. A korábban mentett választás megmarad.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'A Brevo a mentett kulcshoz nem ad listákat (hibás kulcs, vagy a Brevo nem érhető el): nincs mit kiválasztani. A korábban mentett választás megmarad.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Csak a „Választható” módban érvényes.';

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Szöveg';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'További mezők';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'A mezők feliratai';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Spamvédelem';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['További mezők', 'A kapcsolattal együtt a Brevóban tárolódnak.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Kötelező mezők', 'Ezek nélkül a feliratkozás elutasításra kerül. Csak a megjelenített mezők számítanak.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'Keresztnév',
    'lastname' => 'Vezetéknév',
    'sms' => 'Mobilszám (Brevo: SMS)',
    'landline' => 'Vezetékes telefon (Brevo: LANDLINE_NUMBER)',
    'job_title' => 'Beosztás (Brevo: JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Brevo-attribútum a keresztnévhez', 'Automatikus = a fiók alapattribútuma (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Brevo-attribútum a vezetéknévhez', 'Automatikus = a fiók alapattribútuma (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Automatikus';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Felirat: keresztnév', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Felirat: vezetéknév', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Felirat: mobilszám', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Felirat: vezetékes telefon', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Felirat: beosztás', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Üzenet: üres kötelező mező', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Üzenet: a telefonszám nem nemzetközi', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Üzenet: a cím már fel van iratkozva', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Üzenet: sikertelen biztonsági ellenőrzés', 'Üres = alapértelmezés (szürkén látható), az oldalon annak nyelvén.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Feliratkozás óránként', 'Megerősítő e-mailek óránként az összes látogatóra együtt. 0 = nincs korlát.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Feliratkozás naponta', 'Megerősítő e-mailek naponta az összes látogatóra együtt. 0 = nincs korlát.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Beépítve és mindig bekapcsolva: egy láthatatlan feladat, amelyet a látogató böngészője a cím begépelése közben megold (ALTCHA-módszer, sütik nélkül, a látogatónak semmire sem kell kattintania), rejtett mező a botok ellen, más weboldalakról és szkriptekből érkező kérések elutasítása, címenként egy megerősítő e-mail 24 óránként, látogatónként legfeljebb 2 feliratkozás óránként és 3 naponta. Alatta: az összes látogatóra együtt érvényes korlát. Megállítja az IP-címet váltogató botokat; ha eléri, a rendszernapló jelzi.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Csak akkor használatos, ha ez a névmező megjelenik.';
