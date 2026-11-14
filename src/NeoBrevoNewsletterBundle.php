<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * NEO Brevo Newsletter — a self-contained, export-ready Contao bundle that adds a
 * GDPR-friendly newsletter sign-up powered by Brevo. The operator stores the API
 * key on "Access keys and licences" and picks the Brevo contact lists in the
 * front-end module or the "Brevo sign-up" form field; visitors subscribe through
 * the module or the form, and Brevo sends the double-opt-in confirmation.
 *
 * The bundle root holds the Contao resources (contao/, config/, public/),
 * which is why getPath() points one level above this src/ directory.
 */
final class NeoBrevoNewsletterBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
