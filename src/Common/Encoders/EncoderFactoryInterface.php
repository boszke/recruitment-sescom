<?php

declare(strict_types=1);

namespace App\Common\Encoders;

interface EncoderFactoryInterface
{
    public function getEncoder(): EncoderInterface;
}