<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Inscription Brevo';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Correspondance des champs';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Texte de la case à cocher', 'Texte visible à côté de la case d’inscription.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Liste(s) Brevo', 'Une fois l’inscription confirmée, le contact est ajouté à cette ou ces liste(s) (chargées en direct depuis le compte Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Modèle de double opt-in', 'Modèle Brevo de l’e-mail de confirmation (chargé en direct depuis le compte Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Page de confirmation', 'Le lien de confirmation de l’e-mail de double opt-in mène à cette page.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['Champ e-mail', 'Quel champ du formulaire contient l’adresse e-mail ?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Champ prénom (facultatif)', 'Quel champ du formulaire contient le prénom ? Transmis comme attribut du contact.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Champ nom (facultatif)', 'Quel champ du formulaire contient le nom de famille ? Transmis comme attribut du contact.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Pas encore de clé API Brevo dans « Accès et licences » : les listes et modèles du compte ne peuvent pas être chargés. Un choix enregistré auparavant est conservé.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo ne renvoie aucune liste pour la clé enregistrée (clé erronée ou Brevo injoignable) : il n’y a rien à choisir. Un choix enregistré auparavant est conservé.';
