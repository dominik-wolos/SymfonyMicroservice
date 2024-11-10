<?php

declare(strict_types=1);

namespace App\ApiResource\Provider;

use ApiPlatform\State\ProviderInterface;
use App\Components\Player\Entity\Player;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CurrentPlayerProvider implements ProviderInterface
{
    public function __construct(private Security $security)
    {
    }

    public function provide($operation, array $uriVariables = [], array $context = []): ?Player
    {
        $user = $this->security->getUser();

        if (!$user instanceof Player) {
            throw new \LogicException('User is not authenticated.');
        }

        return $user;
    }
}
