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

    public function fail(TaskInterface $task): void
    {
        if (null !== $task->getCompletedAt() || TaskInterface::COMPLETED === $task->getStatus()) {
            throw new \Exception('Task already completed');
        }

        $checkResult = $this->validateTaskEndDate($task, false);

        if ($checkResult) {
            throw new \Exception('Task should not be failed yet');
        }

        $task->setStatus(TaskInterface::EXPIRED);
    }

    public function complete(TaskInterface $task): void
    {
        if (null !== $task->getCompletedAt() || TaskInterface::COMPLETED === $task->getStatus()) {
            throw new \Exception('Task already completed');
        }

        if (TaskInterface::EXPIRED === $task->getStatus()) {
            throw new \Exception('Task already expired');
        }

        $this->validateTaskEndDate($task);

        $task->setCompletedAt(new \DateTimeImmutable());
        $reward = $this->taskRewardCreator->create($task);

        $this->taskRewardCollector->collect($reward);

        $task->setStatus(TaskInterface::COMPLETED);
    }

    private function validateTaskEndDate(TaskInterface $task, bool $exception = true): bool
    {
        $today = (new \DateTimeImmutable())->setTime(0, 0, 0);
        $taskEndsAt = $task->getEndsAt()->setTime(0, 0, 0);

        if ($taskEndsAt < $today) {
            if ($exception) {
                throw new \Exception("The task's end date is in the past. Task scheduling is not allowed.");
            }
            return false;
        }

        if ($taskEndsAt > $today) {
            if ($exception) {
                throw new \Exception("The task's end date is in the future. Task scheduling is not allowed.");
            }
            return false;
        }

        return true;
    }
}
