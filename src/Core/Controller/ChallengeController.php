<?php

declare(strict_types=1);

namespace App\Core\Controller;

use App\Components\Challenge\Provider\DailyChallengeProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class ChallengeController extends AbstractController
{
    public function __construct(
        private readonly DailyChallengeProviderInterface $dailyChallengeProvider,
    ) {
    }

    public function getTodaysChallenge(): Response
    {
        return $this->json($this->dailyChallengeProvider->getDailyChallenge());
    }

    public function accept(): Response
    {
        $dailyChallenge = $this->dailyChallengeProvider->getDailyChallenge();

        $this->dailyChallengeManager->accept($dailyChallenge);
    }
}
