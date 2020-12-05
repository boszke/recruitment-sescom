<?php

declare(strict_types=1);

namespace App\Common\ValueObjects;

class DescriptionAttribute
{
    protected string $description;

    public function __construct(string $description)
    {
        $this->setDescription($description);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    protected function setDescription(string $description): void
    {
        $this->description = trim($description);
    }
}