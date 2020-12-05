<?php

declare(strict_types=1);

namespace App\Reports\Mappers;

use App\Common\ValueObjects\DateAttribute;
use App\Common\ValueObjects\DescriptionAttribute;
use App\Common\ValueObjects\PhoneNumberAttribute;
use App\Reports\Dictionaries\AbstractInformationTypesDictionary;
use App\Reports\DTO\Information;
use Generator;

class InformationMapper implements GeneratorMapperInterface
{
    /**'
     * @param Generator $data
     * @return Generator
     * @throws \Exception
     */
    public function map(Generator $data): Generator
    {
        foreach ($data as $item) {
            yield new Information(
                (int)$item[AbstractInformationTypesDictionary::INFORMATION_NUMBER_FIELD],
                new DescriptionAttribute($item[AbstractInformationTypesDictionary::INFORMATION_DESCRIPTION_FIELD]),
                new DateAttribute($item[AbstractInformationTypesDictionary::INFORMATION_DUE_DATE_FIELD]),
                new PhoneNumberAttribute($item[AbstractInformationTypesDictionary::INFORMATION_PHONE_FIELD])
            );
        }
    }
}