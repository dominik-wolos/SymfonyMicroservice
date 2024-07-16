<?php

declare(strict_types=1);

namespace App\Components\Task\Enum;

enum TaskDifficultyEnum: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';
}
