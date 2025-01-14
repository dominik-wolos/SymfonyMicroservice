<?php

declare(strict_types=1);

namespace App\Components\Challenge\Repository;

use App\Components\Challenge\Entity\ChallengeInterface;

interface ChallengeRepositoryInterface
{
    public function getRandomChallenge(): ChallengeInterface;
}
