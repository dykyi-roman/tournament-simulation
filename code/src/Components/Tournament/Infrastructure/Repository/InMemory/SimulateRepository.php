<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Infrastructure\Repository\InMemory;

use TS\Components\Tournament\Features\Simulate\Entity\Tournament;
use TS\Components\Tournament\Features\Simulate\SimulateRepositoryInterface;

final class SimulateRepository implements SimulateRepositoryInterface
{
    /**
     * @var Tournament[]
     */
    private array $collection;

    public function __construct(Tournament ...$tournament)
    {
        foreach ($tournament as $item) {
            $this->collection[$item->name] = $item;
        }
    }

    public function findByName(string $name): ?Tournament
    {
        if (array_key_exists($name, $this->collection)) {
            return $this->collection[$name];
        }

        return null;
    }
}
