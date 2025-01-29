<?php

declare(strict_types=1);

namespace App\Components\Challenge\Provider;

use ApiPlatform\Metadata\Operation;
use App\Components\Challenge\Creator\DailyChallengeCreatorInterface;
use App\Components\Challenge\Entity\DailyChallengeInterface;
use App\Components\Challenge\Repository\DailyChallengeRepository;

final class DailyChallengeProvider implements DailyChallengeProviderInterface
{
    public function __construct(
        public readonly DailyChallengeRepository $dailyChallengeRepository,
        public readonly DailyChallengeCreatorInterface $dailyChallengeCreator,
    ) {
    }

    public function provide(
        Operation $operation = null,
        array $uriVariables = [],
        array $context = [],
    ): DailyChallengeInterface {
        $challenge = $this->dailyChallengeRepository->getTodaysChallenge();

        if (null !== $challenge) {
            return $challenge;
        }

        return $this->dailyChallengeCreator->createDailyChallenge();
    }
}
