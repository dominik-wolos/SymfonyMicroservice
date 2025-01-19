<?php

declare(strict_types=1);

namespace App\Components\Challenge\Creator;

use App\Components\Challenge\Entity\DailyChallengeInterface;

interface DailyChallengeCreatorInterface
{
    public function createDailyChallenge(): DailyChallengeInterface;
}
