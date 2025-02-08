<?php

declare(strict_types=1);

namespace App\Core\Creator\Resources;

use App\Components\Player\Entity\PlayerInterface;

interface AchievementsCreatorInterface
{
    public function create(PlayerInterface $player): void;
}
