<?php

declare(strict_types=1);

namespace App\Components\Task\Creator;

use App\Components\Player\Entity\PlayerInterface;
use App\Components\Task\Entity\TaskInterface;

interface TaskCreatorInterface
{
    public function createForPlayer(PlayerInterface $player): TaskInterface;
}
