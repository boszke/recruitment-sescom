<?php

declare(strict_types=1);

namespace App\Reports\Readers;

use App\Reports\Exceptions\FileException;

interface ReaderInterface
{
    /**
     * @return string
     * @throws FileException
     */
    public function read(): string;
}