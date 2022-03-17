<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Generate\Entity;

use DateTimeImmutable;

class Tournament
{
    /* @phpstan-ignore-next-line */
    public readonly int $id;

    public function __construct(
        public readonly string $name,
        public readonly int $teamsCount,
        public readonly int $gamesCount,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }
}
