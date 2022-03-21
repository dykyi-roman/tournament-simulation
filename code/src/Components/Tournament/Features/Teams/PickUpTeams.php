<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Teams;

use TS\Components\Tournament\Features\Teams\Entity\Team;

final class PickUpTeams
{
    public function __construct(private TeamsRepositoryInterface $teamsRepository)
    {
    }

    public function create(int $teamsCount): array
    {
        $teams = $this->teamsRepository->findAllTeams();

        shuffle($teams);

        return array_slice(array_map(static fn (Team $team): string => $team->name, $teams), 0, $teamsCount);
    }
}
