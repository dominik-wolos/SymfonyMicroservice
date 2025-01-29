<?php

declare(strict_types=1);

namespace App\Components\Challenge\Manager;

use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Challenge\Provider\DailyChallengeProviderInterface;
use App\Components\Challenge\Repository\DailyChallengeRepository;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Task\Creator\TaskCreatorInterface;
use App\Components\Task\Manager\TaskManagerInterface;
use App\Components\Task\Repository\TaskRepository;
use Webmozart\Assert\Assert;

final class DailyChallengeManager implements DailyChallengeManagerInterface
{
    public function __construct(
        private readonly TaskCreatorInterface $taskCreator,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider,
        private readonly DailyChallengeProviderInterface $dailyChallengeProvider,
        private readonly DailyChallengeRepository $dailyChallengeRepository,
        private readonly TaskRepository $taskRepository,
        private readonly TaskManagerInterface $taskManager,
    ) {
    }

    public function accept(): void
    {
        $player = $this->currentPlayerProvider->provideFromSecurity();
        Assert::isInstanceOf($player, PlayerInterface::class);

        $dailyChallenge = $this->dailyChallengeProvider->provide();
        $todaysChallenge = $this->dailyChallengeRepository->getTodaysChallenge();

        if ($dailyChallenge === $todaysChallenge) {
            throw new \Exception('Challenge already accepted player');
        }

        $this->taskCreator->createForPlayerAndChallenge($player, $dailyChallenge);
    }

    public function complete(): void
    {
        $player = $this->currentPlayerProvider->provideFromSecurity();
        Assert::isInstanceOf($player, PlayerInterface::class);

        $task = $this->taskRepository->findTodaysChallengeTaskByPlayer($player);
        if (null === $task) {
            throw new \Exception('No task found for player');
        }

        $this->taskManager->complete($task);
    }
}
