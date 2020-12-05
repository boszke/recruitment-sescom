<?php

declare(strict_types=1);

namespace App\Reports\DTO;

use App\Common\Interfaces\ArrayableInterface;
use DateTimeImmutable;

abstract class AbstractTypeInformation extends AbstractInformation implements ArrayableInterface
{
    protected DateTimeImmutable $createdAt;

    public function __construct(AbstractInformation $information)
    {
        parent::__construct(
            $information->number,
            $information->descriptionAttribute,
            $information->dateAttribute,
            $information->phoneAttribute
        );
        $this->createdAt = new DateTimeImmutable();
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    abstract public function getType(): string;
}