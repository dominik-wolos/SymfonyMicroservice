<?php

declare(strict_types=1);

namespace App\Core\Collector;

use App\Core\Interface\RewardInterface;

final class AchievementRewardCollector extends RewardCollector implements AchievementRewardCollectorInterface
{
    public function collect(RewardInterface $reward): void
    {
        $this->collectCoins($reward);
        $this->assignExperienceToPlayer($reward);
    }
}
