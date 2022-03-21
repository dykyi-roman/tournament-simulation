<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Forecast;

final class StatisticDto
{
    public function __construct(public readonly string $name)
    {
    }
}
