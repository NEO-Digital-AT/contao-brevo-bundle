<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Contao\System;

/**
 * Marks language files as loaded, so System::loadLanguageFile() returns without the framework.
 */
abstract class LoadedLanguageFiles extends System
{
    public static function mark(string $name): void
    {
        static::$arrLanguageFiles[$name]['en'] = true;
    }

    public static function reset(): void
    {
        static::$arrLanguageFiles = [];
    }
}
