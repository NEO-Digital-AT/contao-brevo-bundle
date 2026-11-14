<?php

declare(strict_types=1);

use Neo\BasicBundle\Access\AccessPage;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;

/*
 * The Brevo part of "Access keys and licences" (page of the Basic bundle): the
 * one API key all Brevo modules and form fields share. No licence.
 */
$GLOBALS['TL_DCA']['tl_neo_access']['fields'][ApiKeyResolver::KEY] = AccessPage::secretField();
AccessPage::addSection(ApiKeyResolver::LEGEND, [ApiKeyResolver::KEY], 'Brevo Newsletter');
