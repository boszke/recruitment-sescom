<?php

declare(strict_types=1);

namespace App\Reports\DTO;

use App\Reports\Dictionaries\AbstractInformationTypesDictionary;

class AccidentInformation extends AbstractTypeInformation
{
    /**
     * Pola bytu zgłoszenie awarii:
     * • opis
     * • typ (zgłoszenie awarii)
     * • priorytet
     * • termin wizyty serwisu (Y-m-d)
     * • status
     * • uwagi serwisu
     * • numer telefonu osoby do kontaktu po stronie klienta
     * • data utworzenia
     */

    public function toArray(): array
    {
        return [
            'opis'                                                => $this->getDescription(),
            'typ'                                                 => $this->getType(),
            'priorytet'                                           => $this->getPriority(),
            'termin wizyty serwisu'                               => $this->getDateString(),
            'status'                                              => $this->getStatus(),
            'uwagi serwisu'                                       => '',
            'numer telefonu osoby do kontaktu po stronie klienta' => $this->getPhone(),
            'data utworzenia'                                     => $this->getCreatedAt()->format('Y-m-d'),
        ];
    }

    protected function getPriority(): string
    {
        if (strpos(strtolower($this->getDescription()), 'bardzo pilne') !== false) {
            return AbstractInformationTypesDictionary::PRIORITY_CRITICAL;
        }

        if (strpos(strtolower($this->getDescription()), 'pilne') !== false) {
            return AbstractInformationTypesDictionary::PRIORITY_HIGH;
        }

        return AbstractInformationTypesDictionary::PRIORITY_NORMAL;
    }

    protected function getDateString(): ?string
    {
        return $this->dateAttribute->getDateTime() !== null ? $this->dateAttribute->getDateTime()->format('Y-m-d') : null;
    }

    protected function getStatus(): string
    {
        return $this->dateAttribute->getDateTime()
            ? AbstractInformationTypesDictionary::STATUS_DEADLINE
            : AbstractInformationTypesDictionary::STATUS_NEW;
    }

    public function getType(): string
    {
        return AbstractInformationTypesDictionary::INFORMATION_TYPE_ACCIDENT;
    }
}