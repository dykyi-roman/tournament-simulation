<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Tests\Tournament\Application\Generate\Message;

use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use TS\Components\Tournament\Application\Generate\Message\CreateTournamentCommand;
use TS\Components\Tournament\Application\Generate\Message\CreateTournamentCommandHandler;
use TS\Components\Tournament\Features\Generate\FailedToGenerateTournamentException;
use TS\Components\Tournament\Features\Generate\MatchesCountCalculator;
use TS\Components\Tournament\Features\Teams\PickUpTeams;
use TS\Components\Tournament\Infrastructure\Repository\InMemory\TeamsRepository;
use TS\Components\Tournament\Infrastructure\Repository\InMemory\TournamentRepository;
use TS\Infrastructure\Cache\InMemoryClient;

/**
 * @coversDefaultClass \TS\Components\Tournament\Application\Generate\Message\CreateTournamentCommandHandler
 */
final class CreateTournamentCommandHandlerTest extends TestCase
{
    public function testSuccessfullyCreateTournament(): void
    {
        $cache = new InMemoryClient();

        $handler = new CreateTournamentCommandHandler(
            new NullLogger(),
            $cache,
            new MatchesCountCalculator(),
            new PickUpTeams(new TeamsRepository()),
            new TournamentRepository()
        );

        $handler(new CreateTournamentCommand('test', 4));

        $item = $cache->getItem('test');

        self::assertSame('test', $item->getKey());
        self::assertSame('0-6', $item->get());
    }

    public function testThrowExceptionWhenTournamentExist(): void
    {
        $this->expectException(FailedToGenerateTournamentException::class);

        $handler = new CreateTournamentCommandHandler(
            new NullLogger(),
            new InMemoryClient(),
            new MatchesCountCalculator(),
            new PickUpTeams(new TeamsRepository()),
            new TournamentRepository()
        );

        $handler(new CreateTournamentCommand('test', 4));
        $handler(new CreateTournamentCommand('test', 4));
    }
}
