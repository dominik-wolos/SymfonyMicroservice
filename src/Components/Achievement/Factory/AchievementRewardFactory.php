<?php

declare(strict_types=1);

namespace App\Components\Achievement\Factory;

use App\Components\Achievement\Entity\AchievementInterface;
use App\Components\Achievement\Entity\AchievementReward;
use App\Components\Achievement\Entity\AchievementRewardInterface;

final class AchievementRewardFactory implements AchievementRewardFactoryInterface
{
    public function create(): AchievementRewardInterface
    {
        return new AchievementReward();
    }

    public function createForAchievement(AchievementInterface $achievement): AchievementRewardInterface
    {
        $reward = $this->create();
        $reward->setAchievement($achievement);

        return $reward;
    }
}
