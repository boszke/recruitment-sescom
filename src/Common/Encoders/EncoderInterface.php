<?php

declare(strict_types=1);

namespace App\Common\Encoders;

use App\Common\Exceptions\EncoderException;

interface EncoderInterface
{
    /**
     * @param array $content
     * @return string
     * @throws EncoderException
     */
    public function encode(array $content): string;
}