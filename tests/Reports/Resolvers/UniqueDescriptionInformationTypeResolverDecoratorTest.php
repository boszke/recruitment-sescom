<?php

declare(strict_types=1);

namespace Tests\Reports\Resolvers;

use App\Common\ValueObjects\DateAttribute;
use App\Common\ValueObjects\DescriptionAttribute;
use App\Common\ValueObjects\PhoneNumberAttribute;
use App\Reports\DTO\AccidentInformation;
use App\Reports\DTO\Information;
use App\Reports\DTO\InformationCollection;
use App\Reports\DTO\ReviewInformation;
use App\Reports\DTO\UnprocessedInformation;
use App\Reports\Resolvers\InformationTypeResolver;
use App\Reports\Resolvers\UniqueDescriptionInformationTypeResolverDecorator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UniqueDescriptionInformationTypeResolverDecoratorTest extends TestCase
{
    private InformationTypeResolver $baseInformationTypeResolver;

    /**
     * @var MockObject|InformationCollection
     */
    private MockObject $informationCollection;

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

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseInformationTypeResolver = new InformationTypeResolver();
        $this->informationCollection = $this->getMockBuilder(InformationCollection::class)->getMock();
        $this->descriptionAttribute = $this->getMockBuilder(DescriptionAttribute::class)->disableOriginalConstructor()->getMock();
        $this->dateAttribute = $this->getMockBuilder(DateAttribute::class)->disableOriginalConstructor()->getMock();
        $this->phoneNumberAttribute = $this->getMockBuilder(PhoneNumberAttribute::class)->disableOriginalConstructor()->getMock();
    }

    public function dataSet(): array
    {
        return [
            [
                'existInCollection' => false,
                'informationDescription' => 'to jest przegląd',
                'expected' => ReviewInformation::class,
            ],
            [
                'existInCollection' => false,
                'informationDescription' => 'to jest awaria',
                'expected' => AccidentInformation::class,
            ],
            [
                'existInCollection' => true,
                'informationDescription' => 'to jest powtórzenie',
                'expected' => UnprocessedInformation::class,
            ],
        ];
    }

    /**
     * @dataProvider dataSet
     * @param bool $existInCollection
     * @param string $informationDescription
     * @param string $expected
     */
    public function testResolve(bool $existInCollection, string $informationDescription, string $expected): void
    {
        $this->descriptionAttribute
            ->expects(self::atLeastOnce())
            ->method('getDescription')
            ->willReturn($informationDescription);

        $information = new Information(1, $this->descriptionAttribute, $this->dateAttribute, $this->phoneNumberAttribute);

        $this->informationCollection
            ->expects($this->atLeastOnce())
            ->method('getCollection')
            ->willReturn($existInCollection ? [$information] : []);

        $resolver = new UniqueDescriptionInformationTypeResolverDecorator($this->baseInformationTypeResolver, $this->informationCollection);
        $resolveResult = $resolver->resolve($information);

        $this->assertInstanceOf($expected, $resolveResult);
    }
}