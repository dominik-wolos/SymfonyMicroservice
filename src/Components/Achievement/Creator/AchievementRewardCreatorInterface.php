<?php

declare(strict_types=1);

namespace App\Components\Achievement\Creator;

use App\Components\Achievement\Entity\AchievementInterface;
use App\Components\Achievement\Entity\AchievementRewardInterface;

interface AchievementRewardCreatorInterface
{
    public function createForAchievement(
        AchievementInterface $achievement,
        bool $flush = true,
    ): AchievementRewardInterface;
}
