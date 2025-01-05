<?php

declare(strict_types=1);

namespace App\Core\Creator;

use App\Components\Player\Entity\PlayerInterface;

interface DefaultDataCreatorInterface
{
    public function create(PlayerInterface $player): void;
}
