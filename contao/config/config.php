<?php

declare(strict_types=1);

use Neo\BrevoNewsletterBundle\Widget\FormBrevoOptin;

// Form generator field "Brevo sign-up" (opt-in checkbox that sends a double opt-in).
$GLOBALS['TL_FFL']['brevo_optin'] = FormBrevoOptin::class;
