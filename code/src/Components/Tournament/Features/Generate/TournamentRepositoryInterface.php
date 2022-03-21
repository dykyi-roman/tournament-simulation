<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Generate;

interface TournamentRepositoryInterface
{
    /**
     * @throws FailedToGenerateTournamentException
     */
    public function create(string $name, array $teams): void;
}
