<?php

declare(strict_types=1);

namespace App\Components\Task\Creator;

use App\Components\Task\Entity\TaskInterface;
use Doctrine\ORM\EntityManagerInterface;

final class CyclicalTaskCreator implements CyclicalTaskCreatorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    private const X_MONTHS = 1;

    public function createMissingTasks(TaskInterface $task, bool $flush = true): void
    {
        $intervalValue = $task->getInterval();
        $measureUnit = $task->getMeasureUnit();
        $endsAt = $task->getEndsAt();
        $futureLimit = (new \DateTimeImmutable())->modify(sprintf('+ %s months', self::X_MONTHS));
        $lastRecursionStartsAt = $task->getLastRecursionStartsAt() ?? $task->getStartsAt();


        while ($lastRecursionStartsAt < $futureLimit) {
            $lastRecursionStartsAt = $this->calculateNextDate($lastRecursionStartsAt, $intervalValue, $measureUnit);
            $endsAt = $this->calculateNextDate($endsAt, $intervalValue, $measureUnit);
            if ($lastRecursionStartsAt < new \DateTime()) {
                continue;
            }

            if ($lastRecursionStartsAt >= $futureLimit) {
                break;
            }

            $newTask = clone $task;
            $newTask->setCreatedAt(new \DateTime());
            $newTask->setStatus(TaskInterface::ACCEPTED);
            $newTask->setStartsAt($lastRecursionStartsAt);
            $newTask->setEndsAt($endsAt);
            $newTask->setMainTask($task);
            $this->entityManager->persist($newTask);
        }

        $task->setLastRecursionStartsAt($lastRecursionStartsAt);
        $this->entityManager->persist($task);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    private function calculateNextDate(
        \DateTimeInterface $currentDate,
        int $interval,
        string $measureUnit,
    ): \DateTime {
        $intervalSpec = match (strtolower($measureUnit)) {
            'day', 'days' => "P{$interval}D",
            'week', 'weeks' => "P{$interval}W",
            'month', 'months' => "P{$interval}M",
            'year', 'years' => "P{$interval}Y",
            default => throw new \InvalidArgumentException("Invalid measure unit: {$measureUnit}"),
        };

        $date = $currentDate instanceof \DateTimeImmutable
            ? \DateTime::createFromImmutable($currentDate)
            : clone $currentDate;

        return $date->add(new \DateInterval($intervalSpec));
    }
}
