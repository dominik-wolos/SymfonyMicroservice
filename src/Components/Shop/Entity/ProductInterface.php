<?php

declare(strict_types=1);

namespace App\Components\Shop\Entity;

interface ProductInterface
{
    public const CREATE = 'product:create';

    public const WRITE = 'product:write';

    public const READ = 'product:read';

    public const ITEM_READ = 'product:item:read';

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
}
