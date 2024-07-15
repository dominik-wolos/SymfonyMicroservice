<?php

declare(strict_types=1);

namespace App\Component\Player\Entity;

use App\Component\Task\Enum\PlayerNotificationSettingsEnum;
use App\Component\User\Entity\User;

class PlayerSettings implements PlayerSettingsInterface
{
    private int $id;

    private User $user;

    private PlayerNotificationSettingsEnum $notificationSettings;

    private bool $holidayMode;

    private string $languagePreferences;

    private bool $darkMode;

    public function getId(): int
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

    public function getNotificationSettings(): PlayerNotificationSettingsEnum
    {
        return $this->notificationSettings;
    }

    public function setNotificationSettings(PlayerNotificationSettingsEnum $notificationSettings): void
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
