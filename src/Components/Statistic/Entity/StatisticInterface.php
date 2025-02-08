<?php

declare(strict_types=1);

namespace App\Components\Statistic\Entity;

use App\Components\Player\Entity\PlayerStatistics;
use App\Components\Statistic\Enum\StatisticLevels;

interface StatisticInterface extends StatisticLevels
{
    public const CREATE = 'statistic:create';

    public const WRITE = 'statistic:write';

    public const READ = 'statistic:read';

    public const ITEM_READ = 'statistic:item:read';

    public function setId(int $id): void;

    public function getId(): ?int;

    public function getPlayerStatistics(): PlayerStatistics;

    public function setPlayerStatistics(PlayerStatistics $playerStatistics): void;

    public function getExperience(): int;

    public function setExperience(int $experience): void;

    public function addExperience(int $experience): void;

    public function getLevel(): int;

    public function setLevel(int $level): void;

    public function getCode(): string;

    public function setCode(string $code): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getIconPath(): string;

    public function setIconPath(string $iconPath): void;
}
