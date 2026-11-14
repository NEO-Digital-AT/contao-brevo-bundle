<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Brevo-aanmelding';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Velden koppelen';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Tekst bij het vakje', 'Zichtbare tekst naast het opt-in-vakje.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Brevo-lijst(en)', 'Het bevestigde contact wordt aan deze lijst(en) toegevoegd (rechtstreeks uit het Brevo-account).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Template voor dubbele opt-in', 'Brevo-template van de bevestigingsmail (rechtstreeks uit het Brevo-account).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Bevestigingspagina', 'De bevestigingslink in de e-mail voor de dubbele opt-in leidt naar deze pagina.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['E-mailveld', 'Welk formulierveld bevat het e-mailadres?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Veld voornaam (optioneel)', 'Welk formulierveld bevat de voornaam? Wordt als contactkenmerk meegestuurd.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Veld achternaam (optioneel)', 'Welk formulierveld bevat de achternaam? Wordt als contactkenmerk meegestuurd.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Nog geen Brevo-API-sleutel onder „Toegang en licenties”: de lijsten en sjablonen van het account kunnen niet worden geladen. Een eerder opgeslagen keuze blijft behouden.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo geeft voor de opgeslagen sleutel geen lijsten (sleutel onjuist of Brevo niet bereikbaar): er is niets te kiezen. Een eerder opgeslagen keuze blijft behouden.';
