<?php

declare(strict_types=1);

namespace App\Components\Task\Dictionary;

interface TaskTypes
{
    public const RECURRING = 'recurring';

    public const ONE_TIME = 'one_time';

    public const CHALLENGE = 'challenge';

    public const TYPES = [
        self::RECURRING,
        self::ONE_TIME,
        self::CHALLENGE,
    ];
}
