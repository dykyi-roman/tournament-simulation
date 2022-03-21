<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Teams;

use TS\Components\Tournament\Features\Teams\Entity\Team;

interface TeamsRepositoryInterface
{
    /**
     * @return Team[]
     */
    public function findAllTeams(): array;
}
