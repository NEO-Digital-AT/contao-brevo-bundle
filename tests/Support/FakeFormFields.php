<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Contao\FormFieldModel;

final class FakeFormFields
{
    /**
     * @return list<FormFieldModel>|null
     */
    public static function findBy(mixed $columns, mixed $values): array|null
    {
        FakeModels::$formFieldQueries[] = [$columns, $values];

        return [] === FakeModels::$formFields ? null : FakeModels::$formFields;
    }
}
