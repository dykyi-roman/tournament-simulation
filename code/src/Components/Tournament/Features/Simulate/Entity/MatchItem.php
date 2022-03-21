<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Simulate\Entity;

use DateTimeImmutable;

class MatchItem
{
    /* @phpstan-ignore-next-line */
    public readonly int $id;

    public function __construct(
        public readonly string $team,
        public readonly int $won,
        public readonly int $drawn,
        public readonly int $lost,
        public readonly int $goalFor,
        public readonly int $goalAgainst,
        public readonly DateTimeImmutable $createdAt,
    ) {
    }
}
