<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Tests\Tournament\Features\Generate;

use Generator;
use PHPUnit\Framework\TestCase;
use TS\Components\Tournament\Features\Generate\MatchesCountCalculator;

/**
 * @coversDefaultClass \TS\Components\Tournament\Features\Generate\MatchesCountCalculator
 */
final class MatchesCountCalculatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testMatchCalculation(int $teamsCount, int $matchesCount): void
    {
        $matchesCountCalculator = new MatchesCountCalculator();

        self::assertSame($matchesCount, $matchesCountCalculator->calculate($teamsCount));
    }

    public function dataProvider(): Generator
    {
        yield 'test by 4 command' => [4, 6];
        yield 'test by 6 command' => [6, 10];
    }
}
