<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Infrastructure\Repository\InMemory;

use TS\Components\Tournament\Features\Simulate\MatchRepositoryInterface;

final class MatchRepository implements MatchRepositoryInterface
{
    public function create(string $team, int $won, int $drawn, int $lost, int $goalFor, int $goalAgainst): void
    {
        //Todo:: ....
    }
}
