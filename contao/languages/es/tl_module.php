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

// Since 1.1.0: additional fields, field labels, messages and spam protection.
$GLOBALS['TL_LANG']['tl_module']['text_legend'] = 'Texto';
$GLOBALS['TL_LANG']['tl_module']['fields_legend'] = 'Campos adicionales';
$GLOBALS['TL_LANG']['tl_module']['labels_legend'] = 'Etiquetas de los campos';
$GLOBALS['TL_LANG']['tl_module']['spam_legend'] = 'Protección contra spam';
$GLOBALS['TL_LANG']['tl_module']['brevo_fields'] = ['Campos adicionales', 'Se guardan con el contacto en Brevo.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_required'] = ['Campos obligatorios', 'Sin estos datos se rechaza la suscripción. Solo cuentan los campos que se muestran.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_fields_options'] = [
    'firstname' => 'Nombre',
    'lastname' => 'Apellidos',
    'sms' => 'Número de móvil (Brevo: SMS)',
    'landline' => 'Teléfono fijo (Brevo: LANDLINE_NUMBER)',
    'job_title' => 'Cargo (Brevo: JOB_TITLE)',
];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_firstname'] = ['Atributo de Brevo para el nombre', 'Automático = el atributo predeterminado de la cuenta (FIRSTNAME, VORNAME, PRENOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_lastname'] = ['Atributo de Brevo para los apellidos', 'Automático = el atributo predeterminado de la cuenta (LASTNAME, NACHNAME, NOM …).'];
$GLOBALS['TL_LANG']['tl_module']['brevo_attr_auto'] = 'Automático';
$GLOBALS['TL_LANG']['tl_module']['brevo_label_firstname'] = ['Etiqueta: nombre', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_lastname'] = ['Etiqueta: apellidos', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_sms'] = ['Etiqueta: número de móvil', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_landline'] = ['Etiqueta: teléfono fijo', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_label_job_title'] = ['Etiqueta: cargo', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_fields'] = ['Mensaje: campo obligatorio vacío', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_phone'] = ['Mensaje: teléfono sin formato internacional', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_repeat'] = ['Mensaje: dirección ya suscrita', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_error_verify'] = ['Mensaje: comprobación de seguridad fallida', 'Vacío = texto por defecto (se muestra en gris), en la página en su idioma.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_hour'] = ['Suscripciones por hora', 'Correos de confirmación por hora para todos los visitantes juntos. 0 = sin límite.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_limit_day'] = ['Suscripciones por día', 'Correos de confirmación por día para todos los visitantes juntos. 0 = sin límite.'];
$GLOBALS['TL_LANG']['tl_module']['brevo_spam_text'] = 'Integrada y siempre activa: una tarea invisible que el navegador del visitante resuelve mientras escribe la dirección (método ALTCHA, sin cookies, el visitante no tiene que hacer clic en nada), un campo oculto contra bots, rechazo de solicitudes de otros sitios web y de scripts, un correo de confirmación por dirección cada 24 horas, como máximo 2 suscripciones por visitante a la hora y 3 al día. Debajo: el límite para todos los visitantes juntos. Detiene a los bots que cambian de dirección IP; cuando se alcanza, lo indica el registro del sistema.';
$GLOBALS['TL_LANG']['tl_module']['brevo_locked_field'] = 'Solo se usa cuando se muestra este campo de nombre.';
