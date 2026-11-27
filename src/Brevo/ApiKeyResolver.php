<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Brevo;

use Neo\BasicBundle\Access\AccessSettings;

/**
 * Resolves the Brevo API key with a clear precedence:
 *  1. the key stored on "Access keys and licences" (Basic bundle), decrypted;
 *  2. otherwise the BREVO_API_KEY environment variable (e.g. from .env).
 *
 * Brevo also offers an "MCP server API key" when a key is created (a switch in the
 * same dialog): the same key, packed for AI tools as base64-encoded JSON
 * ({"api_key": "xkeysib-…"}). The Brevo API itself does not accept that form, so
 * the real key is taken out of it (since 1.1.0).
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
            return self::unwrap($stored);
        }

        $env = $_ENV['BREVO_API_KEY'] ?? $_SERVER['BREVO_API_KEY'] ?? getenv('BREVO_API_KEY');

        return \is_string($env) ? self::unwrap($env) : '';
    }

    /** The API key itself, also when the MCP form of it was entered. */
    public static function unwrap(string $key): string
    {
        $key = trim($key);

        if ('' === $key || str_starts_with($key, 'xkeysib-')) {
            return $key;
        }

        $decoded = base64_decode(strtr($key, '-_', '+/'), true);
        $data = false === $decoded ? null : json_decode($decoded, true);

        if (\is_array($data) && \is_string($data['api_key'] ?? null) && '' !== trim($data['api_key'])) {
            return trim($data['api_key']);
        }

        return $key;
    }
}
