<?php

declare(strict_types=1);

namespace App\Components\Category\Assigner;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;

interface StatisticsAssignerInterface
{
    public function assign(CategoryInterface $category, PlayerInterface $player): void;
}
