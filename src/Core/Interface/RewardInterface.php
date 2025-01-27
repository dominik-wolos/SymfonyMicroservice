<?php

declare(strict_types=1);

namespace App\Core\Interface;

interface RewardInterface
{
    public function canBeCollected(): bool;

    public function getCoins(): int;

    public function setCoins(int $coins): void;

    public function getExperience(): int;

    public function setExperience(int $experience): void;
}
