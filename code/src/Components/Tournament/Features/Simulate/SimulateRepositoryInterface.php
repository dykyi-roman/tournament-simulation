<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Simulate;

use TS\Components\Tournament\Features\Simulate\Entity\Tournament;

interface SimulateRepositoryInterface
{
    public function findByName(string $name): ?Tournament;
}
