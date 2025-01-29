<?php

declare(strict_types=1);

namespace App\Components\Challenge\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Components\Challenge\Entity\DailyChallengeInterface;

interface DailyChallengeProviderInterface extends ProviderInterface
{
    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): DailyChallengeInterface;
}
