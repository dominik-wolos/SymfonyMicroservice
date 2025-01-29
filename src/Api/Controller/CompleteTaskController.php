<?php

declare(strict_types=1);

namespace App\Api\Controller;

use App\Api\Provider\CurrentPlayerProviderInterface;
use App\Components\Player\Entity\PlayerInterface;
use App\Components\Task\Manager\TaskManagerInterface;
use App\Components\Task\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webmozart\Assert\Assert;

final class CompleteTaskController extends AbstractController
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly TaskManagerInterface $taskManager,
        private readonly CurrentPlayerProviderInterface $currentPlayerProvider,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(int $id): Response
    {
        $player = $this->currentPlayerProvider->provideFromSecurity();
        Assert::isInstanceOf($player, PlayerInterface::class);

        $task = $this->taskRepository->findOneByIdAndPlayer($id, $player);

        if (null === $task) {
            throw new NotFoundHttpException();
        }

        try {
            $this->taskManager->complete($task);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json([]);
    }
}
