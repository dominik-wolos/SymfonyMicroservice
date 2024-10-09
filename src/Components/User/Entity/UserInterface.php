<?php

declare(strict_types=1);

namespace App\Components\User\Entity;

use App\Components\Player\Entity\Settings;

interface UserInterface
{
    public const CREATE = 'user:create';

    public const WRITE = 'user:write';

    public const READ = 'user:read';

    public const ITEM_READ = 'user:item:read';

    public function getId(): ?int;

    public function setId(int $id): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getPassword(): string;

    public function setPassword(string $password): void;

    public function getSalt(): string;

    public function setSalt(string $salt): void;

    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): void;

    public function getPlayerSettings(): Settings;

    public function setPlayerSettings(Settings $playerSettings): void;
}
