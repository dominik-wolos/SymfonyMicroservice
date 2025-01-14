<?php

declare(strict_types=1);

namespace App\Components\Challenge\Entity;

interface DailyChallengeInterface
{
    public const CREATE = 'daily_challenge:create';

    public const WRITE = 'daily_challenge:write';

    public const READ = 'daily_challenge:read';

    public const ITEM_READ = 'daily_challenge:item:read';

    public function getId(): int;

    public function setId(int $id): void;

    public function getChallenge(): Challenge;

    public function setChallenge(Challenge $challenge): void;

    public function getDate(): \DateTime;

    public function setDate(\DateTime $date): void;
}
