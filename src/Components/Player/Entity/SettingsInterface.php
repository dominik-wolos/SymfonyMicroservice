<?php

declare(strict_types=1);

namespace App\Components\Player\Entity;

use App\Components\Task\Enum\PlayerNotificationSettingsEnum;
use App\Components\User\Entity\User;

interface SettingsInterface
{
    public function getId(): ?int;

    public function setId(int $id): void;

    public function getUser(): User;

    public function setUser(User $user): void;

    public function getNotificationSettings(): string;

    public function setNotificationSettings(string $notificationSettings): void;

    public function isHolidayMode(): bool;

    public function setHolidayMode(bool $holidayMode): void;

    public function getLanguagePreferences(): string;

    public function setLanguagePreferences(string $languagePreferences): void;

    public function isDarkMode(): bool;

    public function setDarkMode(bool $darkMode): void;
}
