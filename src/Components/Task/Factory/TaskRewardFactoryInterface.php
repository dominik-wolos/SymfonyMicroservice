<?php

declare(strict_types=1);

namespace App\Components\Task\Factory;

use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Entity\TaskRewardInterface;

interface TaskRewardFactoryInterface
{
    public function createNew(): TaskRewardInterface;

    public function createFromData(
        TaskInterface $task,
        int $coins,
        int $experience,
    ): TaskRewardInterface;
}
