<?php

declare(strict_types=1);

namespace App\Components\User\Entity;

use App\Components\Player\Entity\PlayerSettings;

interface UserInterface
{
    public function getUuid(): string;

    public function setUuid(string $uuid): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getPassword(): string;

    public function setPassword(string $password): void;

    public function getSalt(): string;

    public function setSalt(string $salt): void;

    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): void;

    public function getPlayerSettings(): PlayerSettings;

    public function setPlayerSettings(PlayerSettings $playerSettings): void;
}
