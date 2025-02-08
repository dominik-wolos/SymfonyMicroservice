<?php

declare(strict_types=1);

namespace App\Components\Achievement\Factory;

use App\Components\Achievement\Entity\AchievementInterface;

interface AchievementFactoryInterface
{
    public function create(): AchievementInterface;

    public function createWithParams(string $type, int $amount): AchievementInterface;
}
