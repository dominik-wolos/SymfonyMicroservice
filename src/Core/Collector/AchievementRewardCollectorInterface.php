<?php

declare(strict_types=1);

namespace App\Core\Collector;

use App\Core\Interface\RewardInterface;

interface AchievementRewardCollectorInterface
{
    public function collect(RewardInterface $reward): void;
}
