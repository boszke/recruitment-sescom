<?php

declare(strict_types=1);

namespace Tests\Common\Encoders\JsonDecoder;

use App\Common\Encoders\JsonEncoder;
use PHPUnit\Framework\TestCase;

class JsonEncoderTest extends TestCase
{
    public function successDataProvider(): array
    {
        return [
            [
                'data' => [
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
                'expected' => '{"menu":{"id":"file","value":"File","popup":{"menuitem":[{"value":"New"},{"value":"Open"}]}}}',
            ],
            [
                'data'=> [],
                'expected' => '[]',
            ],
        ];
    }

    /**
     * @dataProvider successDataProvider
     * @param array $json
     * @param string $expected
     * @throws \App\Common\Exceptions\EncoderException
     */
    public function testDecodeSuccess(array $json, string $expected): void
    {
        $encoder = new JsonEncoder();
        $data = $encoder->encode($json);

        $this->assertEquals($expected, $data);
    }
}