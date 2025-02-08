<?php

declare(strict_types=1);

namespace App\Core\Collector;

use App\Components\Task\Entity\TaskRewardInterface;
use App\Core\Interface\RewardInterface;

interface TaskRewardCollectorInterface
{
    public function collect(RewardInterface $reward): void;

    public function assignExperienceToStatistics(TaskRewardInterface $reward): void;
}
