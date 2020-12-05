<?php

declare(strict_types=1);

namespace App\Reports\Resolvers;

use App\Reports\DTO\AbstractInformation;
use App\Reports\Dictionaries\AbstractInformationTypesDictionary;
use App\Reports\DTO\AbstractTypeInformation;
use App\Reports\DTO\AccidentInformation;
use App\Reports\DTO\ReviewInformation;

class InformationTypeResolver implements InformationResolverInterface
{
    public function resolve(AbstractInformation $information): AbstractTypeInformation
    {
        if (strpos(strtolower($information->getDescription()), AbstractInformationTypesDictionary::INFORMATION_TYPE_REVIEW) !== false) {
            return new ReviewInformation($information);
        } else {
            return new AccidentInformation($information);
        }
    }
}