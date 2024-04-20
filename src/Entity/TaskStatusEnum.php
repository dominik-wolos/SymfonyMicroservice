<?php

namespace App\Entity;

enum TaskStatusEnum: string
{
    case NEW = 'new';
    case REJECTED = 'rejected';
    case ACCEPTED = 'accepted';
    case COMPLETED = 'completed';
    case EXPIRED = 'expired';
}
