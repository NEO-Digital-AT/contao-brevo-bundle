<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Seznamy';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Dvojité potvrzení (double opt-in)';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Formulář';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Úvodní text', 'Nepovinný text zobrazený nad formulářem.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Seznam(y) kontaktů', 'Seznamy v Brevo, do kterých se kontakt přidá. Vyžaduje API klíč Brevo v části „Přístupy a licence“.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Režim', 'Pevně: vždy vybrané seznamy. Výběr: návštěvník si vybere sám na webu.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Pevně – vždy vybrané seznamy',
    'choice' => 'Výběr – návštěvník si vybere na webu',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Typ výběru', 'Jedna možnost (rozbalovací seznam) nebo více možností (zaškrtávací políčka).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Jedna možnost (rozbalovací seznam)',
    'multiple' => 'Více možností (zaškrtávací políčka)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Zobrazované názvy (nepovinné)', 'Vlastní popisek pro každý seznam: klíč = ID seznamu v Brevo, hodnota = zobrazovaný název. Prázdné = název z Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['Šablona DOI', 'Šablona dvojitého potvrzení z vašeho účtu Brevo (výběr načítaný přímo z účtu). Brevo s ní odešle potvrzovací e-mail.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Potvrzovací stránka', 'Stránka, na kterou se uživatel dostane po kliknutí na odkaz v potvrzovacím e-mailu.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Popisek pole pro e-mail', 'Prázdné = výchozí text (zobrazen šedě), na stránce v jejím jazyce.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Text tlačítka', 'Prázdné = výchozí text (zobrazen šedě), na stránce v jejím jazyce.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Text souhlasu', 'Povinné zaškrtávací políčko (GDPR). Lze použít insert tagy, např. {{link::privacy::Ochrana osobních údajů}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Zpráva o úspěchu', 'Prázdné = výchozí text (zobrazen šedě), na stránce v jejím jazyce.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Hlášení';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Popisek výběru seznamu', 'Prázdné = výchozí text (zobrazen šedě), na stránce v jejím jazyce.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Hlášení: neplatná e-mailová adresa', 'Prázdné = výchozí text (zobrazen šedě), na stránce v jejím jazyce.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Hlášení: nevybrán žádný seznam', 'Prázdné = výchozí text (zobrazen šedě), na stránce v jejím jazyce.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Hlášení: příliš mnoho pokusů', 'Prázdné = výchozí text (zobrazen šedě), na stránce v jejím jazyce.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Hlášení: jiná chyba', 'Prázdné = výchozí text (zobrazen šedě), na stránce v jejím jazyce.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Toto rozšíření je zdarma. Podmínka: právní upozornění každého webu, na kterém veřejně běží, jej uvádí s odkazem na https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Text ke zkopírování (s odkazem):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Přihlášení k newsletteru: Contao Brevo Newsletter od NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Nebo jako HTML pro zdrojový kód právního upozornění:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licence';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Zatím žádný klíč API Brevo v „Přístupy a licence“: seznamy a šablony účtu nelze načíst. Dříve uložená volba zůstane zachována.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo k uloženému klíči nevrací žádné seznamy (chybný klíč nebo Brevo nedostupné): není co vybrat. Dříve uložená volba zůstane zachována.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Platí jen v režimu „Výběr“.';
