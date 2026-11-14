<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Contao\ModuleModel;

final class FakeModules
{
    public static function findByPk(mixed $id): ModuleModel|null
    {
        return FakeModels::$modules[(int) $id] ?? null;
    }
}
