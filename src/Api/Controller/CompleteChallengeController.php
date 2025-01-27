<?php

declare(strict_types=1);

namespace App\Api\Controller;

use App\Components\Challenge\Manager\DailyChallengeManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class CompleteChallengeController extends AbstractController
{
    public function __construct(
        private readonly DailyChallengeManagerInterface $dailyChallengeManager,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(): Response
    {
        $this->dailyChallengeManager->complete();

        $this->entityManager->flush();
        return $this->json([]);
    }
}
