<?php

declare(strict_types=1);

namespace App\Components\Task\Creator;

use App\Components\Challenge\Entity\DailyChallengeInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Task\Entity\TaskInterface;

interface TaskCreatorInterface
{
    public function createForPlayerAndChallenge(
        PlayerInterface $player,
        DailyChallengeInterface $dailyChallenge,
    ): TaskInterface;
}
