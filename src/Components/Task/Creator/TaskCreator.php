<?php

declare(strict_types=1);

namespace App\Components\Task\Creator;

use App\Components\Challenge\Entity\DailyChallengeInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Factory\TaskFactory;
use Doctrine\ORM\EntityManagerInterface;

final class TaskCreator implements TaskCreatorInterface
{
    public function __construct(
        private readonly TaskFactory $taskFactory,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function createForPlayerAndChallenge(
        PlayerInterface $player,
        DailyChallengeInterface $dailyChallenge,
    ): TaskInterface {
        $task = $this->taskFactory->createChallengeForPlayer($player, $dailyChallenge);

        $this->entityManager->persist($task);

        return $task;
    }
}
