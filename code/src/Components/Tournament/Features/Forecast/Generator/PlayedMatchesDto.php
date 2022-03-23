<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Forecast\Generator;

final class PlayedMatchesDto
{
    public function __construct(public readonly array $matches)
    {
    }
}
