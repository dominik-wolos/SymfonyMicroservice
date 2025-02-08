<?php

declare(strict_types=1);

namespace App\Api\Controller;

use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Achievement\Manager\AchievementManagerInterface;
use App\Components\Player\Entity\PlayerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class CompleteAchievementController extends AbstractController
{
    public function __construct(
        private readonly AchievementManagerInterface $achievementManager,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider,
    ) {
    }

    public function __invoke(int $id): Response
    {
        $player = $this->currentPlayerProvider->provideFromSecurity();
        Assert::isInstanceOf($player, PlayerInterface::class);

        $achievement = $player->getAchievementById($id);
        if (null === $achievement) {
            return $this->json(['error' => 'Achievement not found'], Response::HTTP_NOT_FOUND);
        }

        $this->achievementManager->complete($achievement);

        return $this->json([]);
    }
}
