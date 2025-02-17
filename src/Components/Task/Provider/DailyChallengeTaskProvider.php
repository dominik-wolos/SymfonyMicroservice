<?php

declare(strict_types=1);

namespace App\Components\Task\Provider;

use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Task\Entity\TaskInterface;
use App\Components\Task\Repository\TaskRepository;
use Webmozart\Assert\Assert;

final readonly class DailyChallengeTaskProvider implements DailyChallengeTaskProviderInterface
{
    public function __construct(
        private TaskRepository $taskRepository,
        private CurrentPlayerProviderInterface $currentPlayerProvider,
    ) {
    }

    public function provide($operation, array $uriVariables = [], array $context = []): ?TaskInterface
    {
        $player = $this->currentPlayerProvider->provideFromSecurity();
        Assert::notNull($player);

        return $this->taskRepository->findTodaysChallengeTaskByPlayer($player);
    }
}
