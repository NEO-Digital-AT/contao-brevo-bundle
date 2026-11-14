<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Zapis do Brevo';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Przypisanie pól';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Tekst pola wyboru', 'Widoczny tekst obok pola wyboru zgody.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Lista(-y) Brevo', 'Potwierdzony kontakt zostanie dodany do tych list (pobieranych na bieżąco z konta Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Szablon podwójnego potwierdzenia', 'Szablon Brevo dla e-maila z prośbą o potwierdzenie (pobierany na bieżąco z konta Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Strona potwierdzenia', 'Link potwierdzający w e-mailu prowadzi na tę stronę.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['Pole e-mail', 'Które pole formularza zawiera adres e-mail?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Pole imienia (opcjonalne)', 'Które pole formularza zawiera imię? Przekazywane jako atrybut kontaktu.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Pole nazwiska (opcjonalne)', 'Które pole formularza zawiera nazwisko? Przekazywane jako atrybut kontaktu.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Brak jeszcze klucza API Brevo w „Dostępy i licencje”: nie można wczytać list i szablonów konta. Wcześniej zapisany wybór zostaje zachowany.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo nie zwraca list dla zapisanego klucza (błędny klucz lub Brevo nieosiągalne): nie ma czego wybrać. Wcześniej zapisany wybór zostaje zachowany.';
