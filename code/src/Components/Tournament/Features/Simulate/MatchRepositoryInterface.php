<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Simulate;

interface MatchRepositoryInterface
{
    public function create(string $team, int $won, int $drawn, int $lost, int $goalFor, int $goalAgainst): void;
}
