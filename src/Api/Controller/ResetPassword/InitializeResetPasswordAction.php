<?php

declare(strict_types=1);

namespace App\Api\Controller\ResetPassword;

use App\Components\Player\Repository\PlayerRepositoryInterface;
use App\Core\Manager\PasswordReset\VerificationCodeManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class InitializeResetPasswordAction extends AbstractController
{
    public function __construct(
        private readonly PlayerRepositoryInterface $playerRepository,
        private readonly VerificationCodeManagerInterface $verificationCodeManager,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);
        if (false === isset($content['email'])) {
            return $this->json([
                'message' => 'Email is required',
            ], Response::HTTP_BAD_REQUEST);
        }

        $email = $content['email'];

        $player = $this->playerRepository->findOneByEmail($email);

        if (null !== $player) {
            $this->verificationCodeManager->manage($player, $email);
        }

        return $this->json([]);
    }
}
