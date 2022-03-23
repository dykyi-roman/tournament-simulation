<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Infrastructure\Repository\InMemory;

use TS\Components\Tournament\Features\Generate\FailedToGenerateTournamentException;
use TS\Components\Tournament\Features\Generate\TournamentRepositoryInterface;

final class TournamentRepository implements TournamentRepositoryInterface
{
    public function __construct(private array $collection = [])
    {
    }

    /**
     * @throws FailedToGenerateTournamentException
     */
    public function create(string $name, array $teams): void
    {
        if (array_key_exists($name, $this->collection)) {
            throw new FailedToGenerateTournamentException();
        }

        $this->collection[$name] = $teams;
    }
}
