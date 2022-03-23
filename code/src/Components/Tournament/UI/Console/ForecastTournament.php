<?php

declare(strict_types=1);

namespace TS\Components\Tournament\UI\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TS\Components\Tournament\Application\Command\AbstractCommand;
use TS\Components\Tournament\Application\Forecast\ForecastBuilder;
use Webmozart\Assert\Assert;

final class ForecastTournament extends AbstractCommand
{
    protected static $defaultName = 'ts:forecast-tournament';

    public function __construct(private ForecastBuilder $forecastBuilder)
    {
        parent::__construct();
    }

    protected function doExecute(InputInterface $input, SymfonyStyle $io): void
    {
        $tournamentName = (string) $input->getArgument('tournament-name');
        $playedMatches = $this->forecastBuilder->build($tournamentName);

        $io->table(['teams'], array_map(static fn (string $match): array => [$match], $playedMatches->matches));
    }

    protected function configure(): void
    {
        $this->setHelp('This command generate forecast for tournament by name.')->addArgument(
            'tournament-name',
            InputArgument::REQUIRED,
            'Tournament name'
        );
    }

    protected function validateInput(InputInterface $input): void
    {
        Assert::notEmpty($input->getArgument('tournament-name'));
    }
}
