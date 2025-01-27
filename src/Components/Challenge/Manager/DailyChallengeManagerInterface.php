<?php

declare(strict_types=1);

namespace App\Components\Challenge\Manager;

interface DailyChallengeManagerInterface
{
    public function accept(): void;

    public function complete(): void;
}
