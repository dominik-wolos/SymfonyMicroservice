<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Components\User\Entity\User;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity]
#[ORM\Table(name: 'player_settings')]
class Settings implements SettingsInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\Column(type: 'string', unique: false)]
    private string $notificationSettings;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $holidayMode;

    #[ORM\Column(type: 'string', options: ['default' => 'en'])]
    private string $languagePreferences;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $darkMode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getNotificationSettings(): string
    {
        return $this->notificationSettings;
    }

    public function setNotificationSettings(string $notificationSettings): void
    {
        $this->notificationSettings = $notificationSettings;
    }

    public function isHolidayMode(): bool
    {
        return $this->holidayMode;
    }

    public function setHolidayMode(bool $holidayMode): void
    {
        $this->holidayMode = $holidayMode;
    }

    public function getLanguagePreferences(): string
    {
        return $this->languagePreferences;
    }

    public function setLanguagePreferences(string $languagePreferences): void
    {
        $this->languagePreferences = $languagePreferences;
    }

    public function isDarkMode(): bool
    {
        return $this->darkMode;
    }

    public function setDarkMode(bool $darkMode): void
    {
        $this->darkMode = $darkMode;
    }
}
