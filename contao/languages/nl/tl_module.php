<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Lijsten';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Dubbele opt-in';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Formulier';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Inleiding', 'Optionele tekst boven het formulier.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Contactlijst(en)', 'Brevo-lijsten waaraan het contact wordt toegevoegd. Vereist de Brevo-API-sleutel onder “Toegang en licenties”.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Modus', 'Vast: altijd de geselecteerde lijsten. Keuze: de bezoeker kiest zelf op de website.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Vast – altijd de geselecteerde lijsten',
    'choice' => 'Keuze – de bezoeker kiest zelf op de website',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Soort keuze', 'Eén keuze (keuzelijst) of meerdere keuzes (vinkjes).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Eén keuze (keuzelijst)',
    'multiple' => 'Meerdere keuzes (vinkjes)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Weergavenamen (optioneel)', 'Eigen benaming per lijst: sleutel = ID van de Brevo-lijst, waarde = weergavenaam. Leeg = naam in Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['DOI-template', 'Template voor dubbele opt-in uit uw Brevo-account (live keuzelijst). Brevo verstuurt daarmee de bevestigingsmail.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Bevestigingspagina', 'Pagina waarnaar de bezoeker wordt doorgestuurd na het klikken op de link in de bevestigingsmail.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Label e-mailveld', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Tekst op de knop', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Toestemmingstekst', 'Verplicht vinkje (AVG). Insert-tags toegestaan, bijv. {{link::privacy::Privacyverklaring}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Succesmelding', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Meldingen';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Label van de lijstkeuze', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Melding: ongeldig e-mailadres', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Melding: geen lijst gekozen', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Melding: te veel pogingen', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Melding: andere fout', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Deze extensie is gratis. Voorwaarde: de juridische informatie van elke website waarop zij openbaar draait, noemt haar met een link naar https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Tekst om te kopiëren (met link):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Aanmelding nieuwsbrief: Contao Brevo Newsletter van NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Of als HTML voor de broncode van de juridische informatie:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licentie';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Nog geen Brevo-API-sleutel onder „Toegang en licenties”: de lijsten en sjablonen van het account kunnen niet worden geladen. Een eerder opgeslagen keuze blijft behouden.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo geeft voor de opgeslagen sleutel geen lijsten (sleutel onjuist of Brevo niet bereikbaar): er is niets te kiezen. Een eerder opgeslagen keuze blijft behouden.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Werkt alleen in de modus „Keuze”.';
