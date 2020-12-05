<?php

declare(strict_types=1);

namespace App\Reports\DTO;


class InformationCollection
{
    /**
     * @var array|AbstractTypeInformation[]
     */
    private array $collection = [];

    public function add(AbstractTypeInformation $information): self
    {
        $this->collection[] = $information;

        return $this;
    }

    public function filterByType(string $type): array
    {
        return array_filter($this->collection, function (AbstractTypeInformation $information) use ($type): bool {
            return $information->getType() === $type;
        });
    }

    /**
     * @return AbstractTypeInformation[]|array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    public function toArray(): array
    {
        $tmpArray = [];
        foreach ($this->collection as $item) {
            $tmpArray[] = $item->toArray();
        }

        return $tmpArray;
    }
}