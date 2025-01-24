<?php

declare(strict_types=1);

namespace App\Components\Task\Manager;

use App\Components\Statistic\Entity\CategoryStatistic;
use App\Components\Task\Creator\TaskRewardCreatorInterface;
use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Entity\TaskRewardInterface;

final class TaskManager implements TaskManagerInterface
{
    public function __construct(
        private readonly TaskRewardCreatorInterface $taskRewardCreator
    ) {
    }

    public function complete(TaskInterface $task): void
    {
        $task->setCompletedAt(new \DateTimeImmutable());
        $reward = $this->taskRewardCreator->create($task);

        $this->depositReward($task, $reward);
        $this->assignExperienceToStatistics($task, $reward);
        $this->assignExperienceToPlayer($task, $reward);
    }

    public function depositReward(TaskInterface $task, TaskRewardInterface $reward): void
    {
        $wallet = $task->getPlayer()->getWallet();
        $wallet->deposit($reward);
    }

    public function assignExperienceToStatistics(TaskInterface $task, TaskRewardInterface $reward): void
    {
        $category = $task->getCategory();
        $categoryStatistics = $category->getCategoryStatistics();
        $summedMultiplier = 0;

        /**@var $categoryStatistic CategoryStatistic */
        foreach ($categoryStatistics as $categoryStatistic) {
            $summedMultiplier += $categoryStatistic->getMultiplier();
        }

        foreach ($categoryStatistics as $categoryStatistic) {
            $statistic = $categoryStatistic->getStatistic();
            $statistic->addExperience(
                $reward->getExperience() * ($categoryStatistic->getMultiplier() / $summedMultiplier)
            );
        }
    }

    private function assignExperienceToPlayer(TaskInterface $task, TaskRewardInterface $reward): void
    {
        $player = $task->getPlayer();
        $player->addExperience($reward->getExperience());
    }
}
