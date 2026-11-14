<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Seznami';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Dvojna potrditev';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Obrazec';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Uvod', 'Neobvezno besedilo nad obrazcem.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Seznam(i) stikov', 'Seznami Brevo, na katere se doda stik. Potreben je API-ključ Brevo pod „Dostopi in licence“.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Način', 'Fiksno: vedno izbrani seznami. Izbira: obiskovalec izbere sam na spletni strani.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Fiksno – vedno izbrani seznami',
    'choice' => 'Izbira – obiskovalec izbere na spletni strani',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Vrsta izbire', 'Enojna izbira (spustni seznam) ali večkratna izbira (potrditvena polja).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Enojna izbira (spustni seznam)',
    'multiple' => 'Večkratna izbira (potrditvena polja)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Prikazna imena (neobvezno)', 'Lastna oznaka za vsak seznam: ključ = ID seznama v Brevo, vrednost = prikazno ime. Prazno = ime iz Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['Predloga DOI', 'Predloga za dvojno potrditev iz vašega računa Brevo (sprotni izbirnik). Brevo z njo pošlje potrditveno e-pošto.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Potrditvena stran', 'Stran, na katero je uporabnik preusmerjen, ko klikne povezavo v potrditveni e-pošti.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Oznaka polja za e-pošto', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Besedilo gumba', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Besedilo privolitve', 'Obvezno potrditveno polje (GDPR). Dovoljene so vstavne oznake (insert tags), npr. {{link::privacy::Politika zasebnosti}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Sporočilo o uspehu', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Sporočila';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Oznaka izbire seznama', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Sporočilo: neveljaven e-poštni naslov', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Sporočilo: noben seznam ni izbran', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Sporočilo: preveč poskusov', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Sporočilo: druga napaka', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Ta razširitev je brezplačna. Pogoj: pravno obvestilo vsakega spletnega mesta, na katerem javno deluje, jo navaja s povezavo na https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Besedilo za kopiranje (s povezavo):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Prijava na e-novice: Contao Brevo Newsletter podjetja NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Ali kot HTML za izvorno kodo pravnega obvestila:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licenca';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Pod »Dostopi in licence« še ni ključa API Brevo: seznamov in predlog računa ni mogoče naložiti. Prej shranjena izbira ostane.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo za shranjeni ključ ne vrne seznamov (napačen ključ ali Brevo ni dosegljiv): ni česa izbrati. Prej shranjena izbira ostane.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Velja le v načinu »Izbira«.';
