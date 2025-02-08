<?php

declare(strict_types=1);

namespace App\Components\Achievement\Entity;

use App\Core\Interface\RewardInterface;

interface AchievementRewardInterface extends RewardInterface
{
    public function getId(): int;

    public function getAchievement(): AchievementInterface;

    public function setAchievement(AchievementInterface $achievement): void;
}
