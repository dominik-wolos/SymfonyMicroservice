<?php

declare(strict_types=1);

namespace App\Api\Controller\ResetPassword;

use App\Components\Player\Repository\PlayerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class VerificationCodeAction extends AbstractController
{
    public function __construct(
        private readonly PlayerRepositoryInterface $playerRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(string $verificationCode): Response
    {
        $player = $this->playerRepository->findOneByVerificationCode($verificationCode);

        if (null === $player || $player->getResetPasswordTokenValidUntil() < new \DateTimeImmutable()) {
            return $this->json([
                'message' => 'Invalid verification code',
            ], Response::HTTP_BAD_REQUEST);
        }

        $player->setResetPasswordToken(hash('sha512', random_bytes(10)));
        $this->entityManager->flush();

        return $this->json(['token' => $player->getResetPasswordToken()]);
    }
}
