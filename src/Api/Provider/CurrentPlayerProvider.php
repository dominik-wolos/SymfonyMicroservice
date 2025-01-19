<?php

declare(strict_types=1);

namespace App\Api\Provider;

use App\Components\Player\Entity\Player;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CurrentPlayerProvider implements CurrentPlayerProviderInterface
{
    public function __construct(
        private readonly Security $security
    ) {
    }

    public function provide($operation, array $uriVariables = [], array $context = []): ?Player
    {
        return $this->provideFromSecurity();
    }

    public function provideFromSecurity(): ?Player
    {
        $user = $this->security->getUser();

        if (!$user instanceof Player) {
            throw new \LogicException('User is not authenticated.');
        }

        return $user;
    }
}
