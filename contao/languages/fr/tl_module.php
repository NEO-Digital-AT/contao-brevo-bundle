<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Listes';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Double opt-in';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Formulaire';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Introduction', 'Texte facultatif affiché au-dessus du formulaire.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Liste(s) de contacts', 'Listes Brevo auxquelles le contact est ajouté. Nécessite la clé API Brevo dans « Accès et licences ».'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Mode', 'Fixe : toujours les listes sélectionnées. Au choix : le visiteur choisit lui-même sur le site.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Fixe – toujours les listes sélectionnées',
    'choice' => 'Au choix – le visiteur choisit sur le site',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Type de choix', 'Choix unique (liste déroulante) ou choix multiple (cases à cocher).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Choix unique (liste déroulante)',
    'multiple' => 'Choix multiple (cases à cocher)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Noms affichés (facultatif)', 'Libellé personnalisé par liste : clé = ID de la liste Brevo, valeur = nom affiché. Vide = nom défini dans Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['Modèle DOI', 'Modèle de double opt-in de votre compte Brevo (sélection en direct). Brevo envoie l’e-mail de confirmation avec ce modèle.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Page de confirmation', 'Page vers laquelle la personne est redirigée après avoir cliqué sur le lien de l’e-mail de confirmation.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Libellé du champ e-mail', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Texte du bouton', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Texte de consentement', 'Case à cocher obligatoire (RGPD). Les insert tags sont autorisés, p. ex. {{link::privacy::Politique de confidentialité}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Message de réussite', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Messages';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Libellé du choix de listes', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Message : adresse e-mail invalide', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Message : aucune liste choisie', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Message : trop de tentatives', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Message : autre erreur', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Cette extension est gratuite. Condition : les mentions légales de chaque site sur lequel elle fonctionne publiquement la citent avec un lien vers https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Texte à copier (avec lien) :';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Inscription à la newsletter : Contao Brevo Newsletter de NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'Ou en HTML pour le code source des mentions légales :';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licence';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Pas encore de clé API Brevo dans « Accès et licences » : les listes et modèles du compte ne peuvent pas être chargés. Un choix enregistré auparavant est conservé.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo ne renvoie aucune liste pour la clé enregistrée (clé erronée ou Brevo injoignable) : il n’y a rien à choisir. Un choix enregistré auparavant est conservé.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Ne s’applique qu’avec le mode « Au choix ».';

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Texte';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'Champs supplémentaires';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'Libellés des champs';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Protection anti-spam';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['Champs supplémentaires', 'Enregistrés avec le contact dans Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Champs obligatoires', 'Sans ces informations, l’inscription est refusée. Seuls les champs affichés comptent.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'Prénom',
    'lastname' => 'Nom',
    'sms' => 'Numéro de mobile (Brevo : SMS)',
    'landline' => 'Téléphone fixe (Brevo : LANDLINE_NUMBER)',
    'job_title' => 'Fonction (Brevo : JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Attribut Brevo du prénom', 'Automatique = l’attribut par défaut du compte (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Attribut Brevo du nom', 'Automatique = l’attribut par défaut du compte (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Automatique';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Libellé : prénom', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Libellé : nom', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Libellé : numéro de mobile', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Libellé : téléphone fixe', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Libellé : fonction', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Message : champ obligatoire vide', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Message : numéro pas au format international', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Message : adresse déjà inscrite', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Message : échec de la vérification de sécurité', 'Vide = texte par défaut (affiché en gris), dans la langue de la page.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Inscriptions par heure', 'E-mails de confirmation par heure pour tous les visiteurs ensemble. 0 = pas de limite.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Inscriptions par jour', 'E-mails de confirmation par jour pour tous les visiteurs ensemble. 0 = pas de limite.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Intégrée et toujours active : une tâche invisible que le navigateur du visiteur résout pendant la saisie de l’adresse (méthode ALTCHA, sans cookies, rien à cliquer pour le visiteur), un champ caché contre les robots, le refus des requêtes d’autres sites et de scripts, un e-mail de confirmation par adresse en 24 heures, au plus 2 inscriptions par visiteur par heure et 3 par jour. Ci-dessous : la limite pour tous les visiteurs ensemble. Elle arrête les robots qui changent d’adresse IP ; quand elle est atteinte, le journal système l’indique.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Utilisé seulement quand ce champ de nom est affiché.';
