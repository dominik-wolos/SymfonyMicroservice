<?php

declare(strict_types=1);

namespace App\Components\Achievement\Checker;

use App\Components\Achievement\Entity\AchievementInterface;
use App\Components\Achievement\Enum\AchievementTypes;

final class AchievementChecker implements AchievementCheckerInterface
{
    public function check(AchievementInterface $achievement): bool
    {
        $player = $achievement->getPlayer();

        if (AchievementTypes::TASKS_COMPLETED_TYPE === $achievement->getType()) {
            return
                $player->getCompletedTasks() >= $achievement->getRequiredValue()
            ;
        }

        return false;
    }
}
