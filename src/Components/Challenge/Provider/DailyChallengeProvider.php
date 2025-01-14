<?php

declare(strict_types=1);

namespace App\Components\Challenge\Provider;

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

    public function getDailyChallenge(): DailyChallengeInterface
    {
        $challenge = $this->dailyChallengeRepository->getTodaysChallenge();

        if ($challenge !== null) {
            return $challenge;
        }

        return $this->dailyChallengeCreator->createDailyChallenge();
    }
}
