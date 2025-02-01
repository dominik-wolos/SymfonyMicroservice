<?php

declare(strict_types=1);

namespace App\Components\Achievement\Enum;

interface AchievementStates
{
    public const INCOMPLETE_STATE = 'incomplete';

    public const COMPLETED_STATE = 'completed';

    public const COLLECTED_STATE = 'collected';
}
