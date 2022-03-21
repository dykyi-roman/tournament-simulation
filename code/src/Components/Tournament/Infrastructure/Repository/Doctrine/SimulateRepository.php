<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Infrastructure\Repository\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use TS\Components\Tournament\Features\Simulate\Entity\Tournament;
use TS\Components\Tournament\Features\Simulate\SimulateRepositoryInterface;

final class SimulateRepository extends ServiceEntityRepository implements SimulateRepositoryInterface
{
    /* @phpstan-ignore-next-line */
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    public function findByName(string $name): ?Tournament
    {
        $tournament = $this->findOneBy(['name' => $name]);
        if ($tournament instanceof Tournament) {
            return $tournament;
        }

        return null;
    }
}
