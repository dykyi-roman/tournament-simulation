<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Forecast\Generator;

use TS\Components\Tournament\Features\Forecast\ForecastDaoInterface;

final class ForecastGeneratorByGoalDifference implements ForecastGeneratorInterface
{
    public function __construct(private ForecastDaoInterface $forecastDao)
    {
    }

    public function make(string $tournamentName): PlayedMatchesDto
    {
        $matches = $this->forecastDao->findMatchStatisticByGoalDifference($tournamentName);

        return new PlayedMatchesDto($matches);
    }
}
