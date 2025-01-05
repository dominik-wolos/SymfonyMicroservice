<?php

declare(strict_types=1);

namespace App\Core\EventSubscriber;

use App\Components\Player\Entity\PlayerInterface;

final class PlayerRegistrationSubscriber
{
    public function __construct(
    ) {
    }

    public function onPostPersist(PlayerInterface $player): void
    {
    }
}
