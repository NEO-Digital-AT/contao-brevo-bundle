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

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Besedilo';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'Dodatna polja';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'Oznake polj';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Zaščita pred neželeno pošto';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['Dodatna polja', 'Shranijo se pri stiku v Brevu.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Obvezna polja', 'Brez teh podatkov je prijava zavrnjena. Štejejo samo prikazana polja.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'Ime',
    'lastname' => 'Priimek',
    'sms' => 'Mobilna številka (Brevo: SMS)',
    'landline' => 'Stacionarni telefon (Brevo: LANDLINE_NUMBER)',
    'job_title' => 'Delovno mesto (Brevo: JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Atribut Breva za ime', 'Samodejno = privzeti atribut računa (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Atribut Breva za priimek', 'Samodejno = privzeti atribut računa (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Samodejno';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Oznaka: ime', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Oznaka: priimek', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Oznaka: mobilna številka', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Oznaka: stacionarni telefon', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Oznaka: delovno mesto', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Sporočilo: obvezno polje prazno', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Sporočilo: številka ni v mednarodni obliki', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Sporočilo: naslov je že prijavljen', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Sporočilo: varnostno preverjanje ni uspelo', 'Prazno = privzeto besedilo (prikazano sivo), na strani v njenem jeziku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Prijave na uro', 'Potrditvena e-sporočila na uro za vse obiskovalce skupaj. 0 = brez omejitve.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Prijave na dan', 'Potrditvena e-sporočila na dan za vse obiskovalce skupaj. 0 = brez omejitve.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Vgrajeno in vedno vklopljeno: nevidna naloga, ki jo brskalnik obiskovalca reši med vpisovanjem naslova (metoda ALTCHA, brez piškotkov, obiskovalcu ni treba nič klikniti), skrito polje proti botom, zavrnitev zahtev z drugih spletnih mest in iz skript, eno potrditveno e-sporočilo na naslov v 24 urah, največ 2 prijavi na obiskovalca na uro in 3 na dan. Spodaj: omejitev za vse obiskovalce skupaj. Ustavi bote, ki menjajo naslov IP; ko je dosežena, to piše v sistemskem dnevniku.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Uporablja se samo, ko je to polje z imenom prikazano.';
