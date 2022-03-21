<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Infrastructure\Repository\Doctrine;

use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use TS\Components\Tournament\Features\Simulate\Entity\MatchItem;
use TS\Components\Tournament\Features\Simulate\MatchRepositoryInterface;

final class MatchRepository extends ServiceEntityRepository implements MatchRepositoryInterface
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchItem::class);
    }

    public function create(string $team, int $won, int $drawn, int $lost, int $goalFor, int $goalAgainst): void
    {
        $entityManager = $this->registry->getManager();
        $entityManager->persist(new MatchItem($team, $won, $drawn, $lost, $goalFor, $goalAgainst, new DateTimeImmutable()));

        $this->save();
    }

    /**
     * @throws UniqueConstraintViolationException
     */
    private function save(): void
    {
        $entityManager = $this->registry->getManager();
        $entityManager->flush();
    }
}
