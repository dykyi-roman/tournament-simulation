<?php

namespace TS\Components\Tournament\Features\Forecast;

interface ForecastDaoInterface
{
    public function findMatchStatisticByGoalDifference(string $tournamentName): array;
}