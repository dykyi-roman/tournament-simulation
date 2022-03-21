<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Infrastructure\Repository\Doctrine;

use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;
use TS\Components\Tournament\Features\Generate\Entity\Tournament;
use TS\Components\Tournament\Features\Generate\FailedToGenerateTournamentException;
use TS\Components\Tournament\Features\Generate\TournamentRepositoryInterface;

final class TournamentRepository extends ServiceEntityRepository implements TournamentRepositoryInterface
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    /**
     * @throws FailedToGenerateTournamentException
     */
    public function create(string $name, array $teams): void
    {
        try {
            $entityManager = $this->registry->getManager();
            $entityManager->persist(new Tournament($name, $teams, new DateTimeImmutable()));

            $this->save();
        } catch (UniqueConstraintViolationException) {
            throw FailedToGenerateTournamentException::tournamentExist($name);
        } catch (Throwable $exception) {
            throw FailedToGenerateTournamentException::undefined($exception->getMessage());
        }
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
