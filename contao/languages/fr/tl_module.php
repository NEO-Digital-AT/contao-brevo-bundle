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
