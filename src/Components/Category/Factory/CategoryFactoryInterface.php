<?php

declare(strict_types=1);

namespace App\Components\Category\Factory;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;

interface CategoryFactoryInterface
{
    public function createNew(): CategoryInterface;

    public function createForPlayerAndCodeAndName(
        PlayerInterface $player,
        string $code,
        string $name,
    ): CategoryInterface;
}
