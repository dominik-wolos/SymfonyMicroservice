<?php

declare(strict_types=1);

namespace App\Components\Challenge\Factory;

use App\Components\Challenge\Entity\ChallengeInterface;
use App\Components\Challenge\Entity\DailyChallengeInterface;

interface DailyChallengeFactoryInterface
{
    public function create(): DailyChallengeInterface;

    public function createForChallengeAndToday(ChallengeInterface $challenge): DailyChallengeInterface;
}
