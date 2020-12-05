<?php

declare(strict_types=1);

namespace Tests\Common\Decoders\JsonDecoder;

use App\Common\Decoders\JsonDecoder;
use PHPUnit\Framework\TestCase;

class JsonDecoderTest extends TestCase
{
    public function successDataProvider(): array
    {
        return [
            [
                'json' => '{
                              "menu": {
                                "id": "file",
                                "value": "File",
                                "popup": {
                                    "menuitem": [
                                        {"value": "New"},
                                        {"value": "Open"}
                                    ]
                                }
                              }
                            }',
                'expected' => [
                    'menu' => [
                        'id' => 'file',
                        'value' => 'File',
                        'popup' => [
                            'menuitem' => [
                                ['value' => 'New'],
                                ['value' => 'Open'],
                            ]
                        ]
                    ],
                ],
            ],
            [
                'json' => '[]',
                'expected'=> [],
            ],
        ];
    }

    /**
     * @dataProvider successDataProvider
     * @param string $json
     * @param array $expected
     * @throws \App\Common\Exceptions\DecoderException
     */
    public function testDecodeSuccess(string $json, array $expected): void
    {
        $decoder = new JsonDecoder();
        $data = $decoder->decode($json);

        $this->assertEquals($expected, $data);
    }
}