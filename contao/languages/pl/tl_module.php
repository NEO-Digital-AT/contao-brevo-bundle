<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Listy';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Podwójne potwierdzenie';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Formularz';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Wprowadzenie', 'Opcjonalny tekst wyświetlany nad formularzem.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Lista(-y) kontaktów', 'Listy Brevo, do których zostanie dodany kontakt. Wymaga klucza API Brevo w „Dostępy i licencje”.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Tryb', 'Stały: zawsze wybrane listy. Wybór: odwiedzający sam wybiera na stronie.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Stały – zawsze wybrane listy',
    'choice' => 'Wybór – odwiedzający wybiera na stronie',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Rodzaj wyboru', 'Jednokrotny wybór (lista rozwijana) lub wielokrotny wybór (pola wyboru).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Jednokrotny wybór (lista rozwijana)',
    'multiple' => 'Wielokrotny wybór (pola wyboru)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Nazwy wyświetlane (opcjonalnie)', 'Własna nazwa dla każdej listy: klucz = ID listy w Brevo, wartość = nazwa wyświetlana. Puste = nazwa z Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['Szablon DOI', 'Szablon podwójnego potwierdzenia z Państwa konta Brevo (wybór na żywo). Brevo wysyła za jego pomocą e-mail z prośbą o potwierdzenie.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Strona potwierdzenia', 'Strona, na którą użytkownik trafia po kliknięciu linku w e-mailu potwierdzającym.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Etykieta pola e-mail', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Tekst przycisku', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Tekst zgody', 'Obowiązkowe pole wyboru (RODO). Można używać insert tagów, np. {{link::privacy::Polityka prywatności}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Komunikat o powodzeniu', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Komunikaty';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Etykieta wyboru listy', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Komunikat: nieprawidłowy adres e-mail', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Komunikat: nie wybrano listy', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Komunikat: zbyt wiele prób', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Komunikat: inny błąd', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'To rozszerzenie jest bezpłatne. Warunek: nota prawna każdej strony, na której działa publicznie, wymienia je z linkiem do https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Tekst do skopiowania (z linkiem):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Zapis do newslettera: Contao Brevo Newsletter firmy NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Albo jako HTML do kodu źródłowego noty prawnej:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licencja';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Brak jeszcze klucza API Brevo w „Dostępy i licencje”: nie można wczytać list i szablonów konta. Wcześniej zapisany wybór zostaje zachowany.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo nie zwraca list dla zapisanego klucza (błędny klucz lub Brevo nieosiągalne): nie ma czego wybrać. Wcześniej zapisany wybór zostaje zachowany.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Działa tylko w trybie „Wybór”.';
