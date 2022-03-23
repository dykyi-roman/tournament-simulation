<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Tests\Tournament\Application\Simulate;

use PHPUnit\Framework\TestCase;
use TS\Components\Tournament\Application\Simulate\Message\SimulateTournamentMatchCommand;
use TS\Components\Tournament\Application\Simulate\Message\SimulateTournamentMatchCommandHandler;
use TS\Components\Tournament\Features\Simulate\Entity\Tournament;
use TS\Components\Tournament\Features\Simulate\MatchSimulator;
use TS\Components\Tournament\Features\Simulate\SimulateRepositoryInterface;
use TS\Components\Tournament\Features\Simulate\TournamentFinishException;
use TS\Components\Tournament\Features\Simulate\TournamentNotFoundException;
use TS\Components\Tournament\Infrastructure\Repository\InMemory\MatchRepository;
use TS\Components\Tournament\Infrastructure\Repository\InMemory\SimulateRepository;
use TS\Infrastructure\Cache\InMemoryClient;

/**
 * @coversDefaultClass \TS\Components\Tournament\Application\Simulate\Message\SimulateTournamentMatchCommandHandler
 */
final class SimulateTournamentMatchCommandHandlerTest extends TestCase
{
    public function testThrowExceptionWhenTournamentNotFoundInRepository(): void
    {
        $this->expectException(TournamentNotFoundException::class);

        $handler = new SimulateTournamentMatchCommandHandler(
            $this->createSimulateRepository(new Tournament('ttt', [])),
            new InMemoryClient(),
            new MatchSimulator(new MatchRepository())
        );

        $handler(new SimulateTournamentMatchCommand('test'));
    }

    public function testThrowExceptionWhenTournamentNotFoundInCache(): void
    {
        $this->expectException(TournamentNotFoundException::class);

        $handler = new SimulateTournamentMatchCommandHandler(
            $this->createSimulateRepository(new Tournament('test', ['Arsenal', 'Dynamo'])),
            new InMemoryClient(),
            new MatchSimulator(new MatchRepository())
        );

        $handler(new SimulateTournamentMatchCommand('test'));
    }

    public function testThrowExceptionWhenTournamentIsFinish(): void
    {
        $this->expectException(TournamentFinishException::class);

        $handler = new SimulateTournamentMatchCommandHandler(
            $this->createSimulateRepository(new Tournament('test', ['Arsenal', 'Dynamo'])),
            new InMemoryClient(['test' => '6-6']),
            new MatchSimulator(new MatchRepository())
        );

        $handler(new SimulateTournamentMatchCommand('test'));
    }

    private function createSimulateRepository(?Tournament $tournament): SimulateRepositoryInterface
    {
        return new SimulateRepository($tournament);
    }
}
