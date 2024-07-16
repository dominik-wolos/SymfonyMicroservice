<?php

declare(strict_types=1);

namespace App\Components\Task\Enum;

enum TaskStatusEnum: string
{
    case NEW = 'new';
    case REJECTED = 'rejected';
    case ACCEPTED = 'accepted';
    case COMPLETED = 'completed';
    case EXPIRED = 'expired';
}
