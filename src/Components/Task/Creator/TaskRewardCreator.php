<?php

declare(strict_types=1);

namespace App\Components\Task\Creator;

use App\Components\Task\Calculator\TaskReward\CoinsCalculatorInterface;
use App\Components\Task\Calculator\TaskReward\ExperienceCalculatorInterface;
use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Entity\TaskRewardInterface;
use App\Components\Task\Factory\TaskRewardFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Webmozart\Assert\Assert;

final class TaskRewardCreator implements TaskRewardCreatorInterface
{
    public function __construct(
        private readonly CoinsCalculatorInterface $coinsCalculator,
        private readonly ExperienceCalculatorInterface $experienceCalculator,
        private readonly TaskRewardFactoryInterface $taskRewardFactory,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function create(TaskInterface $task): TaskRewardInterface
    {
        $reward =  $this->taskRewardFactory->createFromData(
            $task,
            $this->coinsCalculator->calculate($task),
            $this->experienceCalculator->calculate($task)
        );

        $this->entityManager->persist($reward);

        return $reward;
    }
}
