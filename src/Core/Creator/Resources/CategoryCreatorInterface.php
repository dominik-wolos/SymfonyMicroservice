<?php

declare(strict_types=1);

namespace App\Core\Creator\Resources;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;

interface CategoryCreatorInterface
{
    public function createFromArray(array $category, PlayerInterface $player): CategoryInterface;
}
