<?php

declare(strict_types=1);

namespace App\Components\Achievement\Entity;

use App\Components\Player\Entity\PlayerInterface;
use App\Core\Interface\RewardInterface;

interface AchievementRewardInterface extends RewardInterface
{
    public function getId(): int;

    public function getPlayer(): PlayerInterface;

    public function setPlayer(PlayerInterface $player): void;

    public function getAchievement(): AchievementInterface;

    public function setAchievement(AchievementInterface $achievement): void;
}
