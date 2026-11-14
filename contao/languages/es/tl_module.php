<?php

declare(strict_types=1);

$GLOBALS['TL_LANG']['tl_module']['lists_legend'] = 'Listas';
$GLOBALS['TL_LANG']['tl_module']['doi_legend'] = 'Doble confirmación';
$GLOBALS['TL_LANG']['tl_module']['form_legend'] = 'Formulario';

$GLOBALS['TL_LANG']['tl_module']['brevo_intro'] = ['Introducción', 'Texto opcional que se muestra encima del formulario.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Lista(s) de contactos', 'Listas de Brevo a las que se añade el contacto. Requiere la clave de API de Brevo en «Accesos y licencias».'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode'] = ['Modo', 'Fijo: siempre las listas seleccionadas. A elegir: el visitante elige en la web.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_mode_options'] = [
    'fixed' => 'Fijo – siempre las listas seleccionadas',
    'choice' => 'A elegir – el visitante elige en la web',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type'] = ['Tipo de selección', 'Selección única (lista desplegable) o múltiple (casillas).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_choice_type_options'] = [
    'single' => 'Selección única (lista desplegable)',
    'multiple' => 'Selección múltiple (casillas)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_list_labels'] = ['Nombres visibles (opcional)', 'Etiqueta propia por lista: clave = ID de la lista en Brevo, valor = nombre visible. Vacío = nombre de Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_doi_template'] = ['Plantilla DOI', 'Plantilla de doble confirmación de su cuenta de Brevo (selección en directo). Brevo envía con ella el correo de confirmación.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_redirect'] = ['Página de confirmación', 'Página a la que se redirige al usuario tras hacer clic en el enlace del correo de confirmación.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_email_label'] = ['Etiqueta del campo de correo', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_button'] = ['Texto del botón', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_consent'] = ['Texto de consentimiento', 'Casilla obligatoria (RGPD). Se admiten insert tags, p. ej. {{link::privacy::Política de privacidad}}.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_success'] = ['Mensaje de éxito', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];

$GLOBALS['TL_LANG']['tl_module']['messages_legend'] = 'Mensajes';
$GLOBALS['TL_LANG']['tl_module']['brevo_lists_label'] = ['Etiqueta de la selección de listas', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_invalid'] = ['Mensaje: dirección de correo no válida', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_choose'] = ['Mensaje: ninguna lista elegida', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_limit'] = ['Mensaje: demasiados intentos', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_generic'] = ['Mensaje: otro error', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_text'] = 'Esta extensión es gratuita. Condición: el aviso legal de cada sitio web en el que funcione públicamente la menciona con un enlace a https://neo-digital.at.';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example_label'] = 'Texto para copiar (con enlace):';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_example'] = 'Suscripción al boletín: Contao Brevo Newsletter de NEO Digital';
$GLOBALS['TL_LANG']['tl_module']['brevo_licence_html_label'] = 'O en HTML para el código fuente del aviso legal:';
$GLOBALS['TL_LANG']['tl_module']['licence_legend'] = 'Licencia';

// Settings without effect: the reason at the field (Backend\FieldLock).
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'] = 'Aún no hay clave API de Brevo en «Accesos y licencias»: no se pueden cargar las listas ni las plantillas de la cuenta. Se conserva una selección guardada antes.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_answer'] = 'Brevo no devuelve listas para la clave guardada (clave errónea o Brevo no accesible): no hay nada que elegir. Se conserva una selección guardada antes.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'] = 'Solo tiene efecto en el modo «A elegir».';
