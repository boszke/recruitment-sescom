<?php

declare(strict_types=1);

namespace App\Reports\DTO;

use App\Reports\Dictionaries\AbstractInformationTypesDictionary;

class UnprocessedInformation extends AbstractTypeInformation
{
    private string $reason;

    public function __construct(AbstractInformation $information, string $reason)
    {
        parent::__construct($information);
        $this->reason = $reason;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getType(): string
    {
        return AbstractInformationTypesDictionary::INFORMATION_TYPE_UNPROCESSED;
    }

    public function toArray(): array
    {
        return [
            'number' => $this->getNumber(),
            'reason' => $this->getReason(),
        ];
    }
}