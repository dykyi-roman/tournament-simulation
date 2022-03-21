<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Simulate\Entity;

class Tournament
{
    /* @phpstan-ignore-next-line */
    public readonly int $id;

    public function __construct(public readonly string $name, public readonly array $teams)
    {
    }
}
