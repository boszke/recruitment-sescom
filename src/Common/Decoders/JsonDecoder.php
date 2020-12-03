<?php

declare(strict_types=1);

namespace App\Common\Decoders;

use App\Common\Exceptions\DecoderException;

class JsonDecoder implements DecoderInterface
{
    /**
     * @param string $content
     * @return array
     * @throws DecoderException
     */
    public function decode(string $content): array
    {
        $jsonDecodedData = json_decode($content, true);

        if ($jsonDecodedData === null || json_last_error() !== JSON_ERROR_NONE) {
            throw new DecoderException('Error decoding data.');
        }

        return $jsonDecodedData;
    }
}