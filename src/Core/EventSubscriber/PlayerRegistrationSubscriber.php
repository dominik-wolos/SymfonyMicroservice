<?php

declare(strict_types=1);

namespace App\Core\EventSubscriber;

use App\Components\Player\Entity\Player;
use App\Components\Player\Entity\PlayerInterface;
use App\Core\Creator\DefaultDataCreator;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

final class PlayerRegistrationSubscriber
{
    public function __construct(
    ) {
    }

    public function onPostPersist(PlayerInterface $player): void
    {

    }
}
