<?php

declare(strict_types=1);

namespace App\Core\Manager\PasswordReset;

use App\Components\Player\Entity\PlayerInterface;

interface VerificationCodeManagerInterface
{
    public function manage(PlayerInterface $player, string $to): void;
}
