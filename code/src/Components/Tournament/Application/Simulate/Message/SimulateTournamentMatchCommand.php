<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Application\Simulate\Message;

/**
 * @see \TS\Components\Tournament\Application\Simulate\Message\SimulateTournamentMatchCommandHandler
 *
 * @throws \TS\Components\Tournament\Features\Simulate\TournamentNotFoundException
 * @throws \TS\Components\Tournament\Features\Simulate\TournamentFinishException
 */
final class SimulateTournamentMatchCommand
{
    public function __construct(public readonly string $tournamentName)
    {
    }
}
