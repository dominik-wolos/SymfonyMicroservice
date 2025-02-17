<?php

declare(strict_types=1);

namespace App\Components\Task\Calculator\TaskReward;

use App\Components\Challenge\Provider\DailyChallengeProviderInterface;
use App\Components\Task\Entity\TaskInterface;
use Webmozart\Assert\Assert;

final class CoinsCalculator implements CoinsCalculatorInterface
{
    public function __construct(
        private readonly DailyChallengeProviderInterface $dailyChallengeProvider
    ) {
    }

    public function calculate(TaskInterface $task): int
    {
        if (null === $task->getReward()) {
            return 0;
        }

        $challenge = $this->dailyChallengeProvider->provide();
        Assert::notNull($challenge->getId());

        return $challenge->getCoins();
    }
}
