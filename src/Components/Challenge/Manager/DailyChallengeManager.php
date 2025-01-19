<?php

declare(strict_types=1);

namespace App\Components\Challenge\Manager;

use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Task\Creator\TaskCreatorInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DailyChallengeManager implements DailyChallengeManagerInterface
{
    public function __construct(
        private readonly TaskCreatorInterface $taskCreator,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function accept(): void
    {
        $player = $this->currentPlayerProvider->provideFromSecurity();
        $task = $this->taskCreator->createForPlayer($player);
    }

    public function complete()
    {
        // Complete the challenge
    }

    public function fail()
    {
        // Cancel the challenge
    }
}
