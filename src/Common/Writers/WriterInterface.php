<?php

declare(strict_types=1);

namespace App\Common\Writers;

use App\Common\Exceptions\FileException;

interface WriterInterface
{
    /**
     * @param $data
     * @return mixed
     * @throws FileException
     */
    public function write($data): void;
}