<?php

declare(strict_types=1);

namespace App\Components\Shop\Enum;

interface AugmentTypes
{
    public const ALL = [
        self::BOOSTER,
        self::SHIELD,
    ];

    public const BOOSTER = 'booster';

    public const SHIELD = 'shield';
}
