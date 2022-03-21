<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Infrastructure\Repository\InMemory;

use TS\Components\Tournament\Features\Teams\Entity\Team as TeamEntity;
use TS\Components\Tournament\Features\Teams\TeamsRepositoryInterface;
use UnitEnum;

final class TeamsRepository implements TeamsRepositoryInterface
{
    /**
     * @return TeamEntity[]
     */
    public function findAllTeams(): array
    {
        return array_map(static fn (UnitEnum $enum): TeamEntity => new TeamEntity($enum->value), Team::cases());
    }
}
