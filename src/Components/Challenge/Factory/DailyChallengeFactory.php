<?php

declare(strict_types=1);

namespace App\Components\Challenge\Factory;

use App\Components\Challenge\Entity\ChallengeInterface;
use App\Components\Challenge\Entity\DailyChallenge;
use App\Components\Challenge\Entity\DailyChallengeInterface;

final class DailyChallengeFactory implements DailyChallengeFactoryInterface
{
    public function create(): DailyChallengeInterface
    {
        return new DailyChallenge();
    }

    public function createForChallengeAndToday(ChallengeInterface $challenge): DailyChallengeInterface
    {
        $dailyChallenge = new DailyChallenge();
        $dailyChallenge->setDate(new \DateTime('today'));
        $dailyChallenge->setChallenge($challenge);

        return $dailyChallenge;
    }
}
