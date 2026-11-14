<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Brevo-feliratkozás';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Mezők hozzárendelése';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Jelölőnégyzet szövege', 'A hozzájárulási jelölőnégyzet mellett látható szöveg.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Brevo-lista/listák', 'A megerősített kapcsolat ezekre a listákra kerül (közvetlenül a Brevo-fiókból).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Dupla megerősítés sablonja', 'A megerősítő e-mail Brevo-sablonja (közvetlenül a Brevo-fiókból).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Megerősítő oldal', 'A megerősítő e-mailben lévő hivatkozás erre az oldalra vezet.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['E-mail mező', 'Melyik űrlapmező adja az e-mail-címet?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Keresztnév mező (nem kötelező)', 'Melyik űrlapmező adja a keresztnevet? Kapcsolati attribútumként kerül elküldésre.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Vezetéknév mező (nem kötelező)', 'Melyik űrlapmező adja a vezetéknevet? Kapcsolati attribútumként kerül elküldésre.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Még nincs Brevo API-kulcs a „Hozzáférések és licencek” oldalon: a fiók listái és sablonjai nem tölthetők be. A korábban mentett választás megmarad.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'A Brevo a mentett kulcshoz nem ad listákat (hibás kulcs, vagy a Brevo nem érhető el): nincs mit kiválasztani. A korábban mentett választás megmarad.';
