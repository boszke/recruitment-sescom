<?php

declare(strict_types=1);

namespace App\Common\Encoders;

use App\Common\Exceptions\EncoderException;

class JsonEncoder implements EncoderInterface
{
    /**
     * @inheritDoc
     */
    public function encode(array $content): string
    {
        $encodedData = json_encode($content, JSON_UNESCAPED_UNICODE);

        if ($encodedData === null || json_last_error() !== JSON_ERROR_NONE) {
            throw new EncoderException('Error encoding data.');
        }

        return $encodedData;
    }
}