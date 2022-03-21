<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Application\Generate\Message;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TS\Components\Tournament\Features\Generate\FailedToGenerateTournamentException;
use TS\Components\Tournament\Features\Generate\MatchsCountCalculator;
use TS\Components\Tournament\Features\Generate\TournamentRepositoryInterface;
use TS\Components\Tournament\Features\Teams\PickUpTeams;
use TS\Infrastructure\Cache\CacheItem;

final class CreateTournamentCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private CacheItemPoolInterface $cacheItemPool,
        private MatchsCountCalculator $matchsCountCalculator,
        private PickUpTeams $pickUpTeams,
        private TournamentRepositoryInterface $tournamentRepository
    ) {
    }

    public function __invoke(CreateTournamentCommand $command): void
    {
        try {
            $teams = $this->pickUpTeams->create($command->teamsCount);
            $this->tournamentRepository->create($command->name, $teams);

            $count = $this->matchsCountCalculator->calculate($command->teamsCount);
            $this->cacheItemPool->save(new CacheItem(sprintf('%s', $command->name), sprintf('0-%d', $count)));
        } catch (FailedToGenerateTournamentException $exception) {
            $this->logger->error(
                implode('::', explode('\\', __METHOD__)),
                array_merge(['error' => $exception->getMessage()], ['data' => get_defined_vars()])
            );

            throw $exception;
        }
    }
}
