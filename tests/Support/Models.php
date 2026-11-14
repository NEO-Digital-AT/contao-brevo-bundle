<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Contao\CoreBundle\Framework\Adapter;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\FormFieldModel;
use Contao\Model;
use Contao\ModuleModel;
use Contao\PageModel;

/**
 * Contao's framework with model adapters that answer from arrays instead of
 * the database: modules, pages and form fields by id.
 */
trait Models
{
    /**
     * @param array<string, mixed> $data
     *
     * @template T of Model
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    private function model(string $class, array $data): Model
    {
        $model = $this->createStub($class);
        $model->method('__get')->willReturnCallback(static fn (string $key): mixed => $data[$key] ?? null);

        return $model;
    }

    /**
     * @param array<int, ModuleModel>    $modules
     * @param array<int, PageModel>      $pages
     * @param list<FormFieldModel>       $formFields
     */
    private function framework(array $modules = [], array $pages = [], array $formFields = []): ContaoFramework
    {
        FakeModels::$modules = $modules;
        FakeModels::$pages = $pages;
        FakeModels::$formFields = $formFields;

        $framework = $this->createStub(ContaoFramework::class);
        $framework->method('getAdapter')->willReturnCallback(static fn (string $class): Adapter => match ($class) {
            ModuleModel::class => new Adapter(FakeModules::class),
            PageModel::class => new Adapter(FakePages::class),
            FormFieldModel::class => new Adapter(FakeFormFields::class),
        });

        return $framework;
    }
}
