<?php

declare(strict_types=1);

namespace App\Components\Achievement\Factory;

use App\Components\Achievement\Entity\Achievement;
use App\Components\Achievement\Entity\AchievementInterface;
use App\Components\Achievement\Enum\AchievementTypes;
use App\Components\Player\Entity\PlayerInterface;

final class AchievementFactory implements AchievementFactoryInterface
{
    public function create(): AchievementInterface
    {
        return new Achievement();
    }

    public function createForPlayerAndTypeAndValue(
        PlayerInterface $player,
        int $value,
        string $type = AchievementTypes::TASKS_COMPLETED_TYPE
    ): AchievementInterface {
        $achievement = $this->create();
        $achievement->setPlayer($player);
        $achievement->setRequiredValue($value);
        $achievement->setType($type);

        return $achievement;
    }
}
