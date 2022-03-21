<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Forecast;

interface ForecastGeneratorInterface
{
    public function makeForecast(): StatisticDto;
}
