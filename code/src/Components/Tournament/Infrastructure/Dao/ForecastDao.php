<?php

namespace TS\Components\Tournament\Infrastructure\Dao;

use Doctrine\DBAL\Connection;
use TS\Components\Tournament\Features\Forecast\ForecastDaoInterface;

final class ForecastDao implements ForecastDaoInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findMatchStatisticByGoalDifference(string $tournamentName): array
    {
        $qb = $this->connection->createQueryBuilder();

        /* @phpstan-ignore-next-line */
        return $qb->addSelect('m.team, SUM(m.goal_for) - SUM(m.goal_against) as result')
            ->from('match', 'm')
            ->innerJoin('m', 'tournament', 't', 't.id = m.tournament_id')
            ->andWhere('t.name = :name')
            ->setParameters([
                'name' => $tournamentName,
            ])
            ->addGroupBy('m.team')
            ->orderBy('result', 'DESC')
            ->execute()
            ->fetchFirstColumn();
    }
}