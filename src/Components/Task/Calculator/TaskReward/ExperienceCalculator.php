<?php

declare(strict_types=1);

namespace App\Components\Task\Calculator\TaskReward;

use App\Components\Challenge\Provider\DailyChallengeProviderInterface;
use App\Components\Task\Entity\TaskInterface;
use Webmozart\Assert\Assert;

final class ExperienceCalculator implements ExperienceCalculatorInterface
{
    private const DIFFICULTY_MULTIPLIER_MAP = [
        TaskInterface::EASY => 1,
        TaskInterface::MEDIUM => 2,
        TaskInterface::HARD => 3,
    ];

    public function __construct(
        private readonly DailyChallengeProviderInterface $dailyChallengeProvider
    ) {
    }

    public function calculate(TaskInterface $task): int
    {
        $player = $task->getPlayer();

        if (TaskInterface::CHALLENGE === $task->getType()) {
            $challenge = $this->dailyChallengeProvider->provide();
            Assert::notNull($challenge->getId());

            return $challenge->getPoints();
        }

        return 10 * self::DIFFICULTY_MULTIPLIER_MAP[$task->getDifficulty()] * $player->getPlayerLevel();
    }
}
