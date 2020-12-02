<?php

declare(strict_types=1);

namespace App\Common\Readers;

use App\Common\Exceptions\FileException;

interface ReaderInterface
{
    /**
     * @return string
     * @throws FileException
     */
    public function read(): string;
}