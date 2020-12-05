<?php

declare(strict_types=1);

namespace App\Reports\Resolvers;

use App\Reports\DTO\AbstractInformation;
use App\Reports\DTO\AbstractTypeInformation;

interface InformationResolverInterface
{
    public function resolve(AbstractInformation $information): AbstractTypeInformation;
}