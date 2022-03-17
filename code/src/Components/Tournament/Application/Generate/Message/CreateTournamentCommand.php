<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Application\Generate\Message;

use TS\Components\Tournament\Features\Generate\FailedToGenerateTournamentException;

/**
 * @see CreateTournamentCommandHandler
 *
 * @throws FailedToGenerateTournamentException
 */
final class CreateTournamentCommand
{
    public function __construct(public readonly string $name, public readonly int $teamsCount)
    {
    }
}
