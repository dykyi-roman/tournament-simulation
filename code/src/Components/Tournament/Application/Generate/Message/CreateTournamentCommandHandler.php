<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Application\Generate\Message;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TS\Components\Tournament\Features\Generate\FailedToGenerateTournamentException;
use TS\Components\Tournament\Features\Generate\GamesCountCalculator;
use TS\Components\Tournament\Features\Generate\TournamentRepositoryInterface;

final class CreateTournamentCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private GamesCountCalculator $gamesCountCalculator,
        private TournamentRepositoryInterface $tournamentRepository
    ) {
    }

    public function __invoke(CreateTournamentCommand $command): void
    {
        try {
            $gamesCount = $this->gamesCountCalculator->calculate($command->teamsCount);
            $this->tournamentRepository->create($command->name, $command->teamsCount, $gamesCount);
        } catch (FailedToGenerateTournamentException $exception) {
            $this->logger->error(
                implode('::', explode('\\', __METHOD__)),
                array_merge(['error' => $exception->getMessage()], ['data' => get_defined_vars()])
            );

            throw $exception;
        }
    }
}
