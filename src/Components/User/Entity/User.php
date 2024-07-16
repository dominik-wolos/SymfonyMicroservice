<?php

declare(strict_types=1);

namespace App\Components\User\Entity;

use App\Components\Player\Entity\PlayerSettings;

class User implements UserInterface
{
    private int $id;

    private string $email;

    private string $password;

    private string $salt;

    private bool $enabled = true;

    private PlayerSettings $playerSettings;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getPlayerSettings(): PlayerSettings
    {
        return $this->playerSettings;
    }

    public function setPlayerSettings(PlayerSettings $playerSettings): void
    {
        $this->playerSettings = $playerSettings;
    }
}
