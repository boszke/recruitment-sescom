<?php

declare(strict_types=1);

namespace App\Common\Decoders;

interface DecoderFactoryInterface
{
    public function getDecoder(): DecoderInterface;
}