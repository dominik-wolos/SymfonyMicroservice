<?php

declare(strict_types=1);

namespace App\Components\Task\Creator;

use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Entity\TaskRewardInterface;

interface TaskRewardCreatorInterface
{
    public function create(TaskInterface $task): TaskRewardInterface;

    public function createNegative(TaskInterface $task): TaskRewardInterface;
}
