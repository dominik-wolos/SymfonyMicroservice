<?php

declare(strict_types=1);

namespace App\Components\Task\Creator;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Task\Entity\TaskInterface;
use Doctrine\ORM\EntityManagerInterface;

final class TaskCreator implements TaskCreatorInterface
{
    public function __construct(
        private readonly TaskFactoryInterface $taskFactory,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function createForPlayer(PlayerInterface $player): TaskInterface
    {
        $task = $this->taskFactory->createForPlayer($player);

        $this->entityManager->persist($task);

        return $task;
    }
}
