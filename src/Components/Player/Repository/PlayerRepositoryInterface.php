<?php

declare(strict_types=1);

namespace App\Components\Player\Repository;

use App\Components\Player\Entity\Player;

interface PlayerRepositoryInterface
{
    public function findOneByEmail(string $email): ?Player;
}
