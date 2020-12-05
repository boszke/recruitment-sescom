<?php

declare(strict_types=1);

namespace App\Common\Services;

use App\Common\Exceptions\EncoderException;
use App\Common\Exceptions\FileException;

interface FileWriterEncoderServiceInterface
{
    /**
     * @param array $data
     * @return mixed
     * @throws EncoderException
     * @throws FileException
     */
    public function run(array $data): void;
}