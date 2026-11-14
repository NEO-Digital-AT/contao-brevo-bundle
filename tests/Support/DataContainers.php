<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Contao\DataContainer;

/**
 * A DataContainer stub that answers $dc->table, $dc->id and $dc->field.
 */
trait DataContainers
{
    private function dataContainer(string $field, int $id = 1, string $table = 'tl_neo_access'): DataContainer
    {
        $dc = $this->createStub(DataContainer::class);
        $dc->method('__get')->willReturnCallback(static fn (string $key): mixed => ['table' => $table, 'id' => $id, 'field' => $field][$key] ?? null);

        return $dc;
    }
}
