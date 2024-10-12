<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Player\Entity\PlayerInterface;

interface StatisticInterface
{
    public const CREATE = 'statistic:create';

    public const WRITE = 'statistic:write';

    public const READ = 'statistic:read';

    public const ITEM_READ = 'statistic:item:read';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function setCode(string $code): void;

    public function getPlayer(): PlayerInterface;

    public function setPlayer(PlayerInterface $player): void;
}
