<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Contao\FormFieldModel;
use Contao\ModuleModel;
use Contao\PageModel;

/**
 * Records of the fake model adapters (see Models).
 */
final class FakeModels
{
    /** @var array<int, ModuleModel> */
    public static array $modules = [];

    /** @var array<int, PageModel> */
    public static array $pages = [];

    /** @var list<FormFieldModel> */
    public static array $formFields = [];

    /** @var list<array{0: mixed, 1: mixed}> */
    public static array $formFieldQueries = [];
}
