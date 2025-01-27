<?php

declare(strict_types=1);

namespace App\Components\Achievements\Entity;

use App\Components\Achievements\Enum\AchievementLevels;
use App\Components\Achievements\Enum\AchievementTypes;

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

    public function getState(): string;

    public function setState(string $state): void;
}
