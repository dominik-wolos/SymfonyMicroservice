<?php

declare(strict_types=1);

namespace App\Components\Challenge\Creator;

use App\Components\Challenge\Entity\DailyChallengeInterface;
use App\Components\Challenge\Factory\DailyChallengeFactoryInterface;
use App\Components\Challenge\Repository\ChallengeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DailyChallengeCreator implements DailyChallengeCreatorInterface
{
    public function __construct(
        public readonly DailyChallengeFactoryInterface $dailyChallengeFactory,
        public readonly ChallengeRepositoryInterface $challengeRepository,
        public readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function createDailyChallenge(): DailyChallengeInterface
    {
        $challenge = $this->challengeRepository->getRandomChallenge();
        $dailyChallenge = $this->dailyChallengeFactory->createForChallengeAndToday($challenge);

        $this->entityManager->persist($dailyChallenge);

        return $dailyChallenge;
    }
}
