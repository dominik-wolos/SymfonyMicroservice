<?php

declare(strict_types=1);

namespace App\Components\Achievement\Calculator;

use App\Components\Achievement\Entity\AchievementInterface;

final class ExperienceCalculator implements ExperienceCalculatorInterface
{
    public function calculate(AchievementInterface $achievement): int
    {
        $player = $achievement->getPlayer();

        return $achievement->getExperience() * $player->getPlayerLevel();
    }
}
