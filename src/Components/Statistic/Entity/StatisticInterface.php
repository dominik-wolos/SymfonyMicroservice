<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

interface StatisticInterface
{
    public function getId(): int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;
}
