<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Application\Simulate\Message;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TS\Components\Tournament\Features\Simulate\MatchSimulator;
use TS\Components\Tournament\Features\Simulate\SimulateRepositoryInterface;
use TS\Components\Tournament\Features\Simulate\TournamentFinishException;
use TS\Components\Tournament\Features\Simulate\TournamentNotFoundException;
use TS\Infrastructure\Cache\CacheItem;

final class SimulateTournamentMatchCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private SimulateRepositoryInterface $simulateRepository,
        private CacheItemPoolInterface $cacheItemPool,
        private MatchSimulator $matchSimulator
    ) {
    }

    /**
     * @throws TournamentFinishException
     * @throws TournamentNotFoundException
     */
    public function __invoke(SimulateTournamentMatchCommand $command): void
    {
        $tournament = $this->simulateRepository->findByName($command->tournamentName);
        if (null === $tournament) {
            throw new TournamentNotFoundException();
        }

        $item = $this->cacheItemPool->getItem($command->tournamentName);
        if (false === $item->isHit()) {
            throw new TournamentNotFoundException();
        }

        $tmp = explode('-', (string) $item->get());
        if ($tmp[0] === $tmp[1]) {
            throw new TournamentFinishException();
        }

        $this->matchSimulator->simulate($tournament->teams, (int) $tmp[0]);
        $this->cacheItemPool->save(
            new CacheItem(sprintf('%s', $command->tournamentName), sprintf('%d-%d', (int) ($tmp[0]) + 1, (int) $tmp[1]))
        );
    }
}
