<?php

declare(strict_types=1);

namespace App\Components\Achievement\Enum;

interface AchievementTypes
{
    public const TASKS_COMPLETED_TYPE = 'tasks_completed';

    public const ALL_TYPES = [
        self::TASKS_COMPLETED_TYPE,
    ];
}
