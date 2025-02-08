<?php

declare(strict_types=1);

namespace App\Components\Achievement\Manager;

use App\Components\Achievement\Entity\AchievementInterface;

interface AchievementManagerInterface
{
    public function complete(AchievementInterface $achievement): void;
}
