<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;


#Get(normalizationContext: ['groups' => [self::SHOW]])
#Patch(normalizationContext: ['groups' => [self::UPDATE]])
#Delete(normalizationContext: ['groups' => [self::DELETE]])
#Put(normalizationContext: ['groups' => [self::UPDATE]])
#Post(normalizationContext: ['groups' => [self::CREATE]])
abstract class Resource implements ApiContextGroups
{

}
