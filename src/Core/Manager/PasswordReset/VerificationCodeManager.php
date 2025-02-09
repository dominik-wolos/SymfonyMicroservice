<?php

declare(strict_types=1);

namespace App\Core\Manager\PasswordReset;

use App\Components\Player\Entity\PlayerInterface;
use App\Core\Sender\ResetPasswordEmailSender;
use Doctrine\ORM\EntityManagerInterface;

final class VerificationCodeManager implements VerificationCodeManagerInterface
{
    public function __construct(
        private readonly ResetPasswordEmailSender $resetPasswordEmailSender,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function manage(PlayerInterface $player, string $to): void
    {
        $expiresAt = new \DateTime('+1 hour');
        $code = random_int(100000, 999999);

        $player->setVerificationCode($code);
        $player->setResetPasswordTokenValidUntil($expiresAt);
        $this->resetPasswordEmailSender->sendEmail($player);

        $this->entityManager->flush();
    }
}
