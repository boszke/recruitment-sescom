<?php

declare(strict_types=1);

namespace App\Common\Writers;

use App\Common\Exceptions\FileException;

interface WriterInterface
{
    /**
     * @param mixed $data
     * @return void
     * @throws FileException
     */
    public function write($data): void;
}