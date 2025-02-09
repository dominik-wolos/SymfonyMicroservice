<?php

declare(strict_types=1);

namespace App\Core\Sender;

use App\Components\Player\Entity\PlayerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

final class ResetPasswordEmailSender
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly Environment $twig
    ) {
    }

    public function sendEmail(PlayerInterface $player): void
    {
        $htmlContent = $this->twig->render('reset_password_email.html.twig', [
            'player' => $player,
        ]);

        $email = (new Email())
            ->from('support@questa.pl')
            ->to($player->getEmail())
            ->subject("Questa - Reset Password")
            ->html($htmlContent)
        ;

        $this->mailer->send($email);
    }
}
