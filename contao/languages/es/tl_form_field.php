<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_form_field']['brevo_legend'] = 'Alta en Brevo';
$GLOBALS['TL_LANG']['tl_form_field']['fields_legend'] = 'Asignación de campos';

$GLOBALS['TL_LANG']['tl_form_field']['brevo_optin_label'] = ['Texto de la casilla', 'Texto visible junto a la casilla de consentimiento.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lists'] = ['Lista(s) de Brevo', 'El contacto confirmado se añade a esta(s) lista(s) (cargadas en directo desde la cuenta de Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_doi_template'] = ['Plantilla de doble confirmación', 'Plantilla de Brevo para el correo de confirmación (cargada en directo desde la cuenta de Brevo).'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_redirect'] = ['Página de confirmación', 'El enlace de confirmación del correo de doble confirmación lleva a esta página.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_email_field'] = ['Campo de correo electrónico', '¿Qué campo del formulario contiene la dirección de correo?'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_firstname_field'] = ['Campo de nombre (opcional)', '¿Qué campo del formulario contiene el nombre? Se envía como atributo del contacto.'];
$GLOBALS['TL_LANG']['tl_form_field']['brevo_lastname_field'] = ['Campo de apellidos (opcional)', '¿Qué campo del formulario contiene los apellidos? Se envía como atributo del contacto.'];

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_key'] = 'Aún no hay clave API de Brevo en «Accesos y licencias»: no se pueden cargar las listas ni las plantillas de la cuenta. Se conserva una selección guardada antes.';
$GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'] = 'Brevo no devuelve listas para la clave guardada (clave errónea o Brevo no accesible): no hay nada que elegir. Se conserva una selección guardada antes.';
