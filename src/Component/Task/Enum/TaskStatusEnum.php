<?php

namespace App\Component\Task\Enum;

enum TaskStatusEnum: string
{
    case NEW = 'new';
    case REJECTED = 'rejected';
    case ACCEPTED = 'accepted';
    case COMPLETED = 'completed';
    case EXPIRED = 'expired';
}
