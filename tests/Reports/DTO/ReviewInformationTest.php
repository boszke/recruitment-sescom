<?php

declare(strict_types=1);

namespace Tests\Reports\DTO;

use App\Common\ValueObjects\DateAttribute;
use App\Common\ValueObjects\DescriptionAttribute;
use App\Common\ValueObjects\PhoneNumberAttribute;
use App\Reports\Dictionaries\AbstractInformationTypesDictionary;
use App\Reports\DTO\Information;
use App\Reports\DTO\ReviewInformation;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ReviewInformationTest extends TestCase
{
    /**
     * @var MockObject|DescriptionAttribute
     */
    private MockObject $descriptionAttribute;

    /**
     * @var MockObject|DateAttribute
     */
    private MockObject $dateAttribute;

    /**
     * @var MockObject|PhoneNumberAttribute
     */
    private MockObject $phoneNumberAttribute;

    /**
     * @var MockObject|Information
     */
    private MockObject $information;

    protected function setUp(): void
    {
        parent::setUp();
        $this->descriptionAttribute = $this->getMockBuilder(DescriptionAttribute::class)->disableOriginalConstructor()->getMock();
        $this->dateAttribute = $this->getMockBuilder(DateAttribute::class)->disableOriginalConstructor()->getMock();
        $this->phoneNumberAttribute = $this->getMockBuilder(PhoneNumberAttribute::class)->disableOriginalConstructor()->getMock();

        $this->information = $this
            ->getMockBuilder(Information::class)
            ->setConstructorArgs([1, $this->descriptionAttribute, $this->dateAttribute, $this->phoneNumberAttribute])
            ->getMock();
    }

    public function correctTestDataProvider(): array
    {
        return [
            [
                'descriptionAttributeMethodsReturn' => [
                    'getDescription' => 'lorem',
                ],
                'phoneAttributeMethodsReturn'       => [
                    'getPhoneNumber' => '12345',
                ],
                'dateAttributeMethodsReturn'        => [
                    'getDateTime' => new DateTime('2020-05-12 11:12:13'),
                ],
                'exitData'                          => [
                    'opis'                                                => 'lorem',
                    'typ'                                                 => AbstractInformationTypesDictionary::INFORMATION_TYPE_REVIEW,
                    'data przeglądu'                                      => '2020-05-12',
                    'tydzień w roku daty przeglądu'                       => 20,
                    'status'                                              => AbstractInformationTypesDictionary::STATUS_PLANNED,
                    'zalecenia dalszej obsługi po przeglądzie'            => '',
                    'numer telefonu osoby do kontaktu po stronie klienta' => '12345',
                ],
            ],
        ];
    }

    /**
     * @dataProvider correctTestDataProvider
     * @param array $descriptionAttributeMethodsReturn
     * @param array $dateAttributeMethodsReturn
     * @param array $phoneAttributeMethodsReturn
     * @param array $exitData
     */
    public function testCorrectArray(
        array $descriptionAttributeMethodsReturn,
        array $phoneAttributeMethodsReturn,
        array $dateAttributeMethodsReturn,
        array $exitData
    ): void
    {
        foreach ($descriptionAttributeMethodsReturn as $method => $result) {
            $this->descriptionAttribute
                ->expects($this->atLeastOnce())
                ->method($method)
                ->willReturn($result);
        }
        foreach ($dateAttributeMethodsReturn as $method => $result) {
            $this->dateAttribute
                ->expects($this->atLeastOnce())
                ->method($method)
                ->willReturn($result);
        }
        foreach ($phoneAttributeMethodsReturn as $method => $result) {
            $this->phoneNumberAttribute
                ->expects($this->atLeastOnce())
                ->method($method)
                ->willReturn($result);
        }

        $returnedArray = (new ReviewInformation($this->information))->toArray();
        unset($returnedArray['data utworzenia']);

        $this->assertEquals($exitData, $returnedArray);
    }
}