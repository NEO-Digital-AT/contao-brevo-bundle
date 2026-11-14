<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

/**
 * Contao's settings (localconfig) of an earlier version, read through Config::get().
 */
final class LegacySettings
{
    public static string $brevoApiKey = '';

    public static function get(string $key): mixed
    {
        return 'brevo_api_key' === $key ? self::$brevoApiKey : null;
    }
}
