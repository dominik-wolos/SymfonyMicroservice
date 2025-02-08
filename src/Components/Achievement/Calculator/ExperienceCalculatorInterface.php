<?php

declare(strict_types=1);

namespace App\Components\Achievement\Calculator;

use App\Components\Achievement\Entity\AchievementInterface;

interface ExperienceCalculatorInterface
{
    public function calculate(AchievementInterface $achievement): int;
}
