<?php

declare(strict_types=1);

namespace App\Components\Achievement\Factory;

use App\Components\Achievement\Entity\AchievementInterface;
use App\Components\Achievement\Entity\AchievementRewardInterface;

interface AchievementRewardFactoryInterface
{
    public function create(): AchievementRewardInterface;

    public function createForAchievement(AchievementInterface $achievement): AchievementRewardInterface;
}
