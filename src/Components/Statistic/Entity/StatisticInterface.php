<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

interface StatisticInterface
{
    public function getUuid(): string;

    public function setUuid(string $uuid): void;

    public function getName(): string;

    public function setName(string $name): void;
}
