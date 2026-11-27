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

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Tekst';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'Extra velden';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'Labels van de velden';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Spambeveiliging';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['Extra velden', 'Worden bij het contact in Brevo opgeslagen.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Verplichte velden', 'Zonder deze gegevens wordt de aanmelding geweigerd. Alleen getoonde velden tellen.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'Voornaam',
    'lastname' => 'Achternaam',
    'sms' => 'Mobiel nummer (Brevo: SMS)',
    'landline' => 'Vaste telefoon (Brevo: LANDLINE_NUMBER)',
    'job_title' => 'Functie (Brevo: JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Brevo-attribuut voor de voornaam', 'Automatisch = het standaardattribuut van het account (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Brevo-attribuut voor de achternaam', 'Automatisch = het standaardattribuut van het account (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Automatisch';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Label: voornaam', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Label: achternaam', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Label: mobiel nummer', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Label: vaste telefoon', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Label: functie', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Melding: verplicht veld leeg', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Melding: telefoonnummer niet internationaal', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Melding: adres al aangemeld', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Melding: beveiligingscontrole mislukt', 'Leeg = standaardtekst (grijs weergegeven), op de pagina in de taal van die pagina.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Aanmeldingen per uur', 'Bevestigingsmails per uur voor alle bezoekers samen. 0 = geen limiet.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Aanmeldingen per dag', 'Bevestigingsmails per dag voor alle bezoekers samen. 0 = geen limiet.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Ingebouwd en altijd actief: een onzichtbare taak die de browser van de bezoeker oplost terwijl het adres wordt getypt (ALTCHA-methode, zonder cookies, de bezoeker hoeft niets aan te klikken), een verborgen veld tegen bots, weigering van verzoeken van andere websites en van scripts, één bevestigingsmail per adres in 24 uur, hoogstens 2 aanmeldingen per bezoeker per uur en 3 per dag. Hieronder: de limiet voor alle bezoekers samen. Die stopt bots die van IP-adres wisselen; wordt hij bereikt, dan staat dat in het systeemlogboek.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Alleen in gebruik als dit naamveld wordt getoond.';
