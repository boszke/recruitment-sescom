<?php

declare(strict_types=1);

namespace App\Reports\DTO;

use App\Reports\Dictionaries\AbstractInformationTypesDictionary;

class ReviewInformation extends AbstractTypeInformation
{
    /**
     * Pola bytu przegląd:
     * • opis
     * • typ (przegląd)
     * • data przeglądu (Y-m-d)
     * • tydzień w roku daty przeglądu
     * • status
     * • zalecenia dalszej obsługi po przeglądzie
     * • numer telefonu osoby do kontaktu po stronie klienta
     * • data utworzenia
     */

    public function toArray(): array
    {
        return [
            'opis'                                                => $this->getDescription(),
            'typ'                                                 => $this->getType(),
            'data przeglądu'                                      => $this->getDateString(),
            'tydzień w roku daty przeglądu'                       => $this->getWeek(),
            'status'                                              => $this->getStatus(),
            'zalecenia dalszej obsługi po przeglądzie'            => '',
            'numer telefonu osoby do kontaktu po stronie klienta' => $this->getPhone(),
            'data utworzenia'                                     => $this->getCreatedAt()->format('Y-m-d'),
        ];
    }

    protected function getDateString(): ?string
    {
        return $this->dateAttribute->getDateTime() ? $this->dateAttribute->getDateTime()->format('Y-m-d') : null;
    }

    protected function getWeek(): ?int
    {
        return $this->dateAttribute->getDateTime() ? (int)$this->dateAttribute->getDateTime()->format('W') : null;
    }

    protected function getStatus(): string
    {
        return $this->dateAttribute->getDateTime()
            ? AbstractInformationTypesDictionary::STATUS_PLANNED
            : AbstractInformationTypesDictionary::STATUS_NEW;
    }

    public function getType(): string
    {
        return AbstractInformationTypesDictionary::INFORMATION_TYPE_REVIEW;
    }
}