<?php

declare(strict_types=1);

namespace App\Component\Task\Enum;

enum PlayerNotificationSettingsEnum: string
{
    case ALL = 'all';
    case IMPORTANT = 'important';
    case NONE = 'none';
}
