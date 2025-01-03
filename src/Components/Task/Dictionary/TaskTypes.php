<?php

declare(strict_types=1);

namespace App\Components\Task\Dictionary;

interface TaskTypes
{
    public const CYCLICAL = 'cyclical';

    public const ONE_TIME = 'one_time';

    public const CHALLENGE = 'challenge';
}