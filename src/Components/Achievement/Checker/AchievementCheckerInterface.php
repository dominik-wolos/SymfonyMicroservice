<?php

declare(strict_types=1);

namespace App\Components\Achievement\Checker;

use App\Components\Achievement\Entity\AchievementInterface;

interface AchievementCheckerInterface
{
    public function check(AchievementInterface $achievement): bool;
}
