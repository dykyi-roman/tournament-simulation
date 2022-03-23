<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Forecast\Generator;

final class ForecastGeneratorByGoalAverage implements ForecastGeneratorInterface
{
    public function make(string $tournamentName): PlayedMatchesDto
    {
        return new PlayedMatchesDto([]);
    }
}
