<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Teams\Entity;

final class Team
{
    public function __construct(public readonly string $name)
    {
    }
}
