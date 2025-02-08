<?php

declare(strict_types=1);

namespace App\Components\Achievement\Factory;

use App\Components\Achievement\Entity\Achievement;
use App\Components\Achievement\Entity\AchievementInterface;

final class AchievementFactory implements AchievementFactoryInterface
{
    public function create(): AchievementInterface
    {
        return new Achievement();
    }

    public function createWithParams(string $type, int $amount): AchievementInterface
    {
        $achievement = $this->create();
        $achievement->setType($type);
        $achievement->setRequiredValue($amount);

        return $achievement;
    }
}
