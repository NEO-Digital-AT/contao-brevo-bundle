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

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Tekst';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'Dodatkowe pola';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'Etykiety pól';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Ochrona przed spamem';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['Dodatkowe pola', 'Zapisywane przy kontakcie w Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Pola wymagane', 'Bez tych danych zapis zostanie odrzucony. Liczą się tylko wyświetlane pola.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'Imię',
    'lastname' => 'Nazwisko',
    'sms' => 'Numer komórkowy (Brevo: SMS)',
    'landline' => 'Telefon stacjonarny (Brevo: LANDLINE_NUMBER)',
    'job_title' => 'Stanowisko (Brevo: JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Atrybut Brevo dla imienia', 'Automatycznie = domyślny atrybut konta (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Atrybut Brevo dla nazwiska', 'Automatycznie = domyślny atrybut konta (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Automatycznie';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Etykieta: imię', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Etykieta: nazwisko', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Etykieta: numer komórkowy', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Etykieta: telefon stacjonarny', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Etykieta: stanowisko', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Komunikat: puste pole wymagane', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Komunikat: numer nie w formacie międzynarodowym', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Komunikat: adres już zapisany', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Komunikat: kontrola bezpieczeństwa nieudana', 'Puste = tekst domyślny (pokazany na szaro), na stronie w jej języku.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Zapisy na godzinę', 'E-maile z potwierdzeniem na godzinę dla wszystkich odwiedzających łącznie. 0 = bez limitu.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Zapisy na dzień', 'E-maile z potwierdzeniem na dzień dla wszystkich odwiedzających łącznie. 0 = bez limitu.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Wbudowana i zawsze włączona: niewidoczne zadanie, które przeglądarka odwiedzającego rozwiązuje podczas wpisywania adresu (metoda ALTCHA, bez plików cookie, odwiedzający niczego nie klika), ukryte pole przeciw botom, odrzucanie żądań z innych stron i ze skryptów, jeden e-mail z potwierdzeniem na adres w ciągu 24 godzin, najwyżej 2 zapisy na odwiedzającego na godzinę i 3 dziennie. Poniżej: limit dla wszystkich odwiedzających łącznie. Zatrzymuje boty zmieniające adres IP; po jego osiągnięciu informuje o tym dziennik systemowy.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Używane tylko wtedy, gdy to pole nazwy jest wyświetlane.';
