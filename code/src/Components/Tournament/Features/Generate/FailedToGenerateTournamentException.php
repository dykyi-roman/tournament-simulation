<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Generate;

use RuntimeException;

/**
 * @psalm-immutable
 */
final class FailedToGenerateTournamentException extends RuntimeException
{
    public static function tournamentExist(string $name): self
    {
        return new self(sprintf('Tournament with name "%s" exist', $name));
    }

    public static function undefined(string $errorMessage): self
    {
        return new self(sprintf('Error: "%s"', $errorMessage));
    }
}
