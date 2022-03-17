<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Features\Generate;

final class GamesCountCalculator
{
    public function calculate(int $teamCount): int
    {
        return ($teamCount - 1) * 2;
    }
}
