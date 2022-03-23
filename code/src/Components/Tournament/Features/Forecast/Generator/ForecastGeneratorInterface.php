<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Forecast\Generator;

interface ForecastGeneratorInterface
{
    public function make(string $tournamentName): PlayedMatchesDto;
}
