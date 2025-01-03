<?php

declare(strict_types=1);

namespace App\Components\Task\Factory;

use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Entity\TaskReward;
use App\Components\Task\Entity\TaskRewardInterface;

final class TaskRewardFactory implements TaskRewardFactoryInterface
{
    public function createNew(): TaskRewardInterface
    {
        return new TaskReward();
    }

    public function createFromData(
        TaskInterface $task,
        int $coins,
        int $experience
    ): TaskRewardInterface {
        $taskReward = $this->createNew();
        $taskReward->setCoins($coins);
        $taskReward->setExperience($experience);
        $taskReward->setTask($task);

        return $taskReward;
    }
}
