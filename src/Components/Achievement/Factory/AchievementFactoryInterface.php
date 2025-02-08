<?php

declare(strict_types=1);

namespace App\Components\Achievement\Factory;

use App\Components\Achievement\Entity\AchievementInterface;
use App\Components\Achievement\Enum\AchievementTypes;
use App\Components\Player\Entity\PlayerInterface;

interface AchievementFactoryInterface
{
    public function create(): AchievementInterface;

    public function createForPlayerAndTypeAndValue(
        PlayerInterface $player,
        int $value,
        string $type = AchievementTypes::TASKS_COMPLETED_TYPE
    ): AchievementInterface;
}
