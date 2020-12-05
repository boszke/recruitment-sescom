<?php

declare(strict_types=1);

namespace App\Reports\DTO;

use App\Common\ValueObjects\DescriptionAttribute;
use App\Common\ValueObjects\DateAttribute;
use App\Common\ValueObjects\PhoneNumberAttribute;

abstract class AbstractInformation
{
    protected int $number;

    protected DescriptionAttribute $descriptionAttribute;

    protected DateAttribute $dateAttribute;

    protected PhoneNumberAttribute $phoneAttribute;

    public function __construct(int $number, DescriptionAttribute $description, DateAttribute $date, PhoneNumberAttribute $phone)
    {
        $this->number = $number;
        $this->descriptionAttribute = $description;
        $this->dateAttribute = $date;
        $this->phoneAttribute = $phone;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getDescription(): string
    {
        return $this->descriptionAttribute->getDescription();
    }

    public function getPhone(): ?string
    {
        return $this->phoneAttribute->getPhoneNumber();
    }
}