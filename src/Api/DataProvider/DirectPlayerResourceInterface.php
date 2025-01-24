<?php

declare(strict_types=1);

namespace App\Api\DataProvider;

use App\Components\Player\Entity\PlayerInterface;

interface DirectPlayerResourceInterface
{
    public function getPlayer(): PlayerInterface;
}
