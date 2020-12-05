<?php

declare(strict_types=1);

namespace App\Common\Services;

use App\Common\Exceptions\DecoderException;
use App\Common\Exceptions\FileException;
use Generator;

interface FileReaderDecoderServiceInterface
{
    /**
     * @return Generator
     * @throws DecoderException
     * @throws FileException
     */
    public function run(): Generator;
}