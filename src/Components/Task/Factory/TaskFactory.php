<?php

declare(strict_types=1);

namespace App\Components\Task\Factory;

use App\Components\Challenge\Entity\ChallengeInterface;
use App\Components\Challenge\Entity\DailyChallengeInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Task\Dictionary\TaskDifficulties;
use App\Components\Task\Dictionary\TaskStates;
use App\Components\Task\Dictionary\TaskTypes;
use App\Components\Task\Entity\Task;
use App\Components\Task\Entity\TaskInterface;

final class TaskFactory
{
    public function create(): TaskInterface
    {
        return new Task();
    }

    public function createForPlayerWithNameAndDescription(
        PlayerInterface $player,
        string $name,
        string $description,
        string $difficulty,
        \DateTimeInterface $startsAt = null,
    ): TaskInterface {
        $task = $this->create();

        $task->setPlayer($player);
        $task->setCreatedAt(new \DateTime('now'));
        $task->setStartsAt($startsAt ?? new \DateTime('now'));
        $task->setDifficulty($difficulty);
        $task->setName($name);
        $task->setDescription($description);
        $task->setStatus(TaskStates::NEW);

        return $task;
    }

    public function createChallengeForPlayer(
        PlayerInterface $player,
        DailyChallengeInterface $dailyChallenge
    ): TaskInterface {
        $challenge = $dailyChallenge->getChallenge();

        $task = $this->createForPlayerWithNameAndDescription(
            $player,
            $challenge->getName(),
            $challenge->getDescription(),
            TaskDifficulties::HARD,
        );

        $task->setType(TaskTypes::CHALLENGE);
        $task->setEndsAt(new \DateTime('tomorrow'));
        $task->setStatus(TaskStates::ACCEPTED);

        return $task;
    }
}
