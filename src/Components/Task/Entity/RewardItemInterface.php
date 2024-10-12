<?php

declare(strict_types=1);

namespace App\Components\Task\Entity;

interface RewardItemInterface
{
    public const CREATE = 'reward_item:create';

    public const WRITE = 'reward_item:write';

    public const READ = 'reward_item:read';

    public const ITEM_READ = 'reward_item:item:read';
}
