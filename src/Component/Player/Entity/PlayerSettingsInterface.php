<?php

declare(strict_types=1);

namespace App\Component\Player\Entity;

use App\Component\Task\Enum\PlayerNotificationSettingsEnum;
use App\Component\User\Entity\User;

interface PlayerSettingsInterface
{
    public function getId(): int;

    public function setId(int $id): void;

    public function getUser(): User;

    public function setUser(User $user): void;

    public function getNotificationSettings(): PlayerNotificationSettingsEnum;

    public function setNotificationSettings(PlayerNotificationSettingsEnum $notificationSettings): void;

    public function isHolidayMode(): bool;

    public function setHolidayMode(bool $holidayMode): void;

    public function getLanguagePreferences(): string;

    public function setLanguagePreferences(string $languagePreferences): void;

    public function isDarkMode(): bool;

    public function setDarkMode(bool $darkMode): void;
}
