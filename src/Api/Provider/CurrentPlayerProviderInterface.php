<?php

declare(strict_types=1);

namespace App\Api\Provider;

use ApiPlatform\State\ProviderInterface;
use App\Components\Player\Entity\Player;

interface CurrentPlayerProviderInterface extends ProviderInterface
{
    public function provide($operation, array $uriVariables = [], array $context = []): ?Player;

    public function provideFromSecurity(): ?Player;
}
