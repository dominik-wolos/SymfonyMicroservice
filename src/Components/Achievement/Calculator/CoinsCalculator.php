<?php

declare(strict_types=1);

namespace App\Components\Achievement\Calculator;

use App\Components\Achievement\Entity\AchievementInterface;

final class CoinsCalculator implements CoinsCalculatorInterface
{
    public function calculate(AchievementInterface $achievement): int
    {
        return $achievement->getCoins();
    }
}
