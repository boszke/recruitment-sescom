<?php

namespace App\Common\ValueObjects;

use App\Common\Decoders\DecoderFactoryInterface;
use App\Common\Decoders\DecoderInterface;
use App\Common\Encoders\EncoderFactoryInterface;
use App\Common\Encoders\EncoderInterface;
use App\Common\Decoders\JsonDecoder;
use App\Common\Encoders\JsonEncoder;

class JsonFile extends AbstractFile implements DecoderFactoryInterface, EncoderFactoryInterface
{
    public function getDecoder(): DecoderInterface
    {
        return new JsonDecoder();
    }

    public function getEncoder(): EncoderInterface
    {
        return new JsonEncoder();
    }
}