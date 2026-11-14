<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Brevo;

use Neo\BasicBundle\Access\AccessSettings;

/**
 * Resolves the Brevo API key with a clear precedence:
 *  1. the key stored on "Access keys and licences" (Basic bundle), decrypted;
 *  2. otherwise the BREVO_API_KEY environment variable (e.g. from .env).
 *
 * Other bundles use this class to reach the key (resolve() is public API).
 */
final class ApiKeyResolver
{
    /** Column of the key on "Access keys and licences" (tl_neo_access). */
    public const KEY = 'brevo_api_key';

    /** Section of the key on "Access keys and licences". */
    public const LEGEND = 'brevo_legend';

    public function __construct(private readonly AccessSettings $access)
    {
    }

    public function resolve(): string
    {
        $stored = $this->access->secret(self::KEY);

        if ('' !== $stored) {
            return $stored;
        }

        $env = $_ENV['BREVO_API_KEY'] ?? $_SERVER['BREVO_API_KEY'] ?? getenv('BREVO_API_KEY');

        return \is_string($env) ? trim($env) : '';
    }
}
