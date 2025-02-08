<?php

declare(strict_types=1);

namespace App\Core\Interface;

use App\Components\Player\Entity\PlayerInterface;

interface RewardInterface
{
    public function canBeCollected(): bool;

    public function getCoins(): int;

    public function setCoins(int $coins): void;

    public function getExperience(): int;

    public function setExperience(int $experience): void;

    public function getPlayer(): PlayerInterface;
}
