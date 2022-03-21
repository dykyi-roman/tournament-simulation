<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Infrastructure\Repository\InMemory;

/**
 * @see https://www.premierleague.com/tables
 */
enum Team: string
{
    case T1 = 'Manchester City';
    case T2 = 'Liverpool';
    case T3 = 'Chelsea';
    case T5 = 'Arsenal';
    case T6 = 'Burnley';
    case T7 = 'Norwich City';
    case T8 = 'Everton';
    case T9 = 'Brentford';
    case T10 = 'Newcastle United';
}
