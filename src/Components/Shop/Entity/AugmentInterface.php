<?php

declare(strict_types=1);

namespace App\Components\Shop\Entity;

use App\Components\Category\Entity\CategoryInterface;
use App\Components\Player\Entity\PlayerInterface;

interface AugmentInterface
{
    public const CREATE = 'item:create';

    public const WRITE = 'item:write';

    public const READ = 'item:read';

    public const ITEM_READ = 'item:item:read';

    public function hasId(): bool;

    public function getId(): int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getPrice(): int;

    public function setPrice(int $price): void;

    public function getDescription(): string;

    public function setDescription(string $description): void;

    public function getCreatedAt(): \DateTimeImmutable;

    public function setCreatedAt(\DateTimeImmutable $createdAt): void;

    public function getUpdatedAt(): \DateTime;

    public function setUpdatedAt(\DateTime $updatedAt): void;

    public function getType(): string;

    public function setType(string $type): void;

    public function getCategory(): CategoryInterface;

    public function setCategory(CategoryInterface $category): void;

    public function getPlayer(): PlayerInterface;

    public function setPlayer(PlayerInterface $player): void;

    public function getValidUntil(): \DateTimeInterface;

    public function getValidForDays(): int;

    public function setValidForDays(int $validForDays): void;

    public function getMultiplier(): int;

    public function setMultiplier(int $multiplier): void;

    public function getCategoryName(): string;

    public function getEndsAt(): \DateTimeImmutable;

    public function setEndsAt(\DateTimeImmutable $endsAt): void;
}
