<?php

declare(strict_types=1);

namespace App\Components\Task\Manager;

use App\Components\Task\Creator\TaskRewardCreatorInterface;
use App\Components\Task\Entity\TaskInterface;
use App\Core\Collector\TaskRewardCollectorInterface;

final class TaskManager implements TaskManagerInterface
{
    public function __construct(
        private readonly TaskRewardCreatorInterface $taskRewardCreator,
        private readonly TaskRewardCollectorInterface $taskRewardCollector,
    ) {
    }

    public function complete(TaskInterface $task): void
    {
        if (null !== $task->getCompletedAt() || TaskInterface::COMPLETED === $task->getStatus()) {
            throw new \Exception('Task already completed');

            return;
        }

        $task->setCompletedAt(new \DateTimeImmutable());
        $reward = $this->taskRewardCreator->create($task);

        $this->taskRewardCollector->collect($reward);

        $task->setStatus(TaskInterface::COMPLETED);
    }
}
