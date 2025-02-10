<?php

declare(strict_types=1);

namespace App\Api\Controller\ResetPassword;

use App\Components\Player\Repository\PlayerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class ChangePasswordAction extends AbstractController
{
    public function __construct(
        private readonly PlayerRepositoryInterface $playerRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(Request $request, string $token): Response
    {
        $content = json_decode($request->getContent(), true);
        if (false === isset($content['password'])) {
            return $this->json([
                'message' => 'Password is required',
            ], Response::HTTP_BAD_REQUEST);
        }

        $password = $content['password'];

        $player = $this->playerRepository->findOneByToken($token);

        if (null === $player || $player->getResetPasswordTokenValidUntil() < new \DateTimeImmutable()) {
            return $this->json([
                'message' => 'Invalid reset token',
            ], Response::HTTP_BAD_REQUEST);
        }


        $hashedPassword = $this->passwordHasher->hashPassword(
            $player,
            $password,
        );

        $player->setResetPasswordToken(null);
        $player->eraseCredentials();
        $player->setPassword($hashedPassword);

        $this->entityManager->flush();

        return $this->json([]);
    }
}
