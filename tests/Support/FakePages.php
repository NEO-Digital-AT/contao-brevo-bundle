<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Contao\PageModel;

final class FakePages
{
    public static function findByPk(mixed $id): PageModel|null
    {
        return FakeModels::$pages[(int) $id] ?? null;
    }
}
