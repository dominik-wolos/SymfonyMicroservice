<?php

declare(strict_types=1);

namespace App\Api\DataProvider;

interface IndirectPlayerResourceInterface extends DirectPlayerResourceInterface
{
    public static function getPlayerPropertyPathParts(): array;
}
