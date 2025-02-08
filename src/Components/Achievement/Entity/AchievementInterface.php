<?php

declare(strict_types=1);

namespace App\Components\Achievement\Entity;

use App\Components\Achievement\Enum\AchievementLevels;
use App\Components\Achievement\Enum\AchievementTypes;
use App\Components\Player\Entity\Player;

interface AchievementInterface extends AchievementLevels, AchievementTypes
{
    public function getId(): int;

    public function setId(int $id): void;

    public function getType(): string;

    public function setType(string $type): void;

    public function getRequiredValue(): float;

    public function setRequiredValue(float $requiredValue): void;

    public function getCoins(): int;

    public function setCoins(int $coins): void;

    public function getExperience(): int;

    public function setExperience(int $experience): void;

    public function getPlayer(): Player;

    public function setPlayer(Player $player): void;

    public function getCompletedAt(): ?\DateTimeInterface;

    public function setCompletedAt(\DateTimeInterface $completedAt): void;

    public function getAchievementReward(): ?AchievementReward;

    public function setAchievementReward(?AchievementReward $achievementReward): void;

    public function isCompleted(): bool;
}
