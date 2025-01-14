<?php

declare(strict_types=1);

namespace App\Components\Challenge\Provider;

use App\Components\Challenge\Entity\DailyChallengeInterface;

interface DailyChallengeProviderInterface
{
    public function getDailyChallenge(): DailyChallengeInterface;
}
