<?php

declare(strict_types=1);

namespace App\Reports\Resolvers;

use App\Reports\DTO\AbstractInformation;
use App\Reports\DTO\AbstractTypeInformation;
use App\Reports\DTO\InformationCollection;
use App\Reports\DTO\UnprocessedInformation;

class UniqueDescriptionInformationTypeResolverDecorator implements InformationResolverInterface
{
    private InformationResolverInterface $informationTypeResolver;

    private InformationCollection $collection;

    public function __construct(InformationResolverInterface $informationTypeResolver, InformationCollection $collection)
    {
        $this->informationTypeResolver = $informationTypeResolver;
        $this->collection = $collection;
    }

    public function resolve(AbstractInformation $information): AbstractTypeInformation
    {
        foreach ($this->collection->getCollection() as $existInformation) {
            if ($existInformation->getDescription() === $information->getDescription()) {
                return new UnprocessedInformation($information, 'Zgłoszenie o takim opisie już istnieje.');
            }
        }

        return $this->informationTypeResolver->resolve($information);
    }
}