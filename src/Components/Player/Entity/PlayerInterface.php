<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

interface PlayerInterface
{
    public const CREATE = 'player:create';

    public const WRITE = 'player:write';

    public const READ = 'player:read';

    public const ITEM_READ = 'player:item:read';

    public const UPDATE = 'player:update';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getPassword(): string;

    public function setPassword(string $password): void;

    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): void;
}
