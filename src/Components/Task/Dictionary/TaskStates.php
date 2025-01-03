<?php

declare(strict_types=1);

namespace App\Components\Task\Dictionary;

interface TaskStates
{
    public const NEW = 'new';

    public const ACCEPTED = 'accepted';

    public const COMPLETED = 'completed';

    public const DECLINED = 'declined';

    public const EXPIRED = 'failed';
}
