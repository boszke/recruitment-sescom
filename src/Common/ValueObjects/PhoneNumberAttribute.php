<?php

declare(strict_types=1);

namespace App\Common\ValueObjects;

class PhoneNumberAttribute
{
    protected ?string $phoneNumber = null;

    public function __construct(?string $phoneNumber)
    {
        $this->setPhoneNumber($phoneNumber);
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    protected function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = !empty($phoneNumber) ? $phoneNumber : null;
    }
}