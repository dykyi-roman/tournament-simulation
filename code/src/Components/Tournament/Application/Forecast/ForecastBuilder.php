<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Application\Forecast;

use TS\Components\Tournament\Features\Forecast\Generator\ForecastGeneratorInterface;
use TS\Components\Tournament\Features\Forecast\Generator\PlayedMatchesDto;

final class ForecastBuilder
{
    public function __construct(private ForecastGeneratorInterface $forecastGenerator)
    {
    }

    public function build(string $tournamentName): PlayedMatchesDto
    {
        return $this->forecastGenerator->make($tournamentName);
    }
}
