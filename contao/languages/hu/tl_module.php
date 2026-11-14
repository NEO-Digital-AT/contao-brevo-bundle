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
