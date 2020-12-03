<?php

declare(strict_types=1);

namespace App\Common\Decoders;

use App\Common\Exceptions\DecoderException;

interface DecoderInterface
{
    /**
     * @param string $content
     * @return array
     * @throws DecoderException
     */
    public function decode(string $content): array;
}