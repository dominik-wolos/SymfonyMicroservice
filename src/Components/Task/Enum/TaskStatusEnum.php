<?php

declare(strict_types=1);

namespace App\Component\Task\Enum;

enum TaskStatusEnum: string
{
    case NEW = 'new';
    case REJECTED = 'rejected';
    case ACCEPTED = 'accepted';
    case COMPLETED = 'completed';
    case EXPIRED = 'expired';
}
