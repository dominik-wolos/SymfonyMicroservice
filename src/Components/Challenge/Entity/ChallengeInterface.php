<?php

declare(strict_types=1);

namespace App\Components\Challenge\Entity;

interface ChallengeInterface
{
    public const CREATE = 'challenge:create';

    public const WRITE = 'challenge:write';

    public const READ = 'challenge:read';

    public const ITEM_READ = 'challenge:item:read';

    public function getId(): ?int;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): string;

    public function setDescription(string $description): void;

    public function getPoints(): int;

    public function setPoints(int $points): void;

    public function getCoins(): int;

    public function setCoins(int $coins): void;
}
