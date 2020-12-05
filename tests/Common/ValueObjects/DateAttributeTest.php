<?php

namespace Tests\Common\ValueObjects;

use App\Common\ValueObjects\DateAttribute;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class DateAttributeTest extends TestCase
{
    public function dateAttributeDataProvider(): array
    {
        return [
            [
                'value'    => null,
                'expected' => null,
            ],
            [
                'value'    => '2020-05-12',
                'expected' => new DateTime('2020-05-12'),
            ],
            [
                'value'    => '2020-05-12 12:13:45',
                'expected' => new DateTime('2020-05-12 12:13:45'),
            ],
        ];
    }

    /**
     * @dataProvider dateAttributeDataProvider
     * @param string|null $value
     * @param DateTime|null $expected
     * @throws Exception
     */
    public function testDateAttribute(?string $value, ?DateTime $expected): void
    {
        $processedDateTime = (new DateAttribute($value))->getDateTime();

        $this->assertEquals($processedDateTime, $expected);
    }

    public function exceptionDataProvider(): array
    {
        return [
            [
                'value' => 'lorem',
            ],
        ];
    }

    /**
     * @dataProvider exceptionDataProvider
     * @param string|null $value
     * @throws Exception
     */
    public function testExceptionDateAttribute(?string $value)
    {
        $this->expectException(Exception::class);
        (new DateAttribute($value))->getDateTime();
    }
}