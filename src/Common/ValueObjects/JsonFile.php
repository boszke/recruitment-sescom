<?php

namespace App\Common\ValueObjects;

use App\Common\Decoders\DecoderFactoryInterface;
use App\Common\Decoders\DecoderInterface;
use App\Common\Decoders\JsonDecoder;

class JsonFile extends AbstractFile implements DecoderFactoryInterface
{
    public function getDecoder(): DecoderInterface
    {
        return new JsonDecoder();
    }
}