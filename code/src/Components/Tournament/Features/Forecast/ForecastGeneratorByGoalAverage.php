<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Forecast;

final class ForecastGeneratorByGoalAverage implements ForecastGeneratorInterface
{
    public function makeForecast(): StatisticDto
    {
        return new StatisticDto('test');
    }
}
