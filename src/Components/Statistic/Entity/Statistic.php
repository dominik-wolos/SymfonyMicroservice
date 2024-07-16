<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

class Statistic implements StatisticInterface
{
    private int $id;

    private string $name;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
