<?php

declare(strict_types=1);

namespace App\Reports\Mappers;

use Generator;

interface GeneratorMapperInterface
{
    /**
     * @param Generator $data
     * @return Generator
     * @throws \Exception
     */
    public function map(Generator $data): Generator;
}