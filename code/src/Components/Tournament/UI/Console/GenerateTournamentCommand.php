<?php

declare(strict_types=1);

namespace TS\Components\Tournament\UI\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use TS\Components\Tournament\Application\Command\AbstractCommand;
use TS\Components\Tournament\Application\Generate\Message\CreateTournamentCommand;
use TS\Components\Tournament\Features\Generate\FailedToGenerateTournamentException;
use Webmozart\Assert\Assert;

final class GenerateTournamentCommand extends AbstractCommand
{
    protected static $defaultName = 'ts:generate-tournament';

    private const MIN_COUNT_OF_TEAMS = 3;
    private const MAX_COUNT_OF_TEAMS = 10;

    public function __construct(private MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command generate a new tournament.')
            ->addArgument('name', InputArgument::REQUIRED, 'Tournament name')
            ->addArgument('teams-count', InputArgument::REQUIRED, 'Teams count');
    }

    protected function doExecute(InputInterface $input, SymfonyStyle $output): void
    {
        $teamsCount = (int) $input->getArgument('teams-count');

        try {
            $this->messageBus->dispatch(new CreateTournamentCommand((string) $input->getArgument('name'), $teamsCount));

            $output->writeln(sprintf('New tournament for %s teams generated!', $teamsCount));
        } catch (FailedToGenerateTournamentException $exception) {
            $output->error(sprintf('Error: %s', $exception->getMessage()));
        }
    }

    protected function validateInput(InputInterface $input): void
    {
        Assert::range((int) $input->getArgument('teams-count'), self::MIN_COUNT_OF_TEAMS, self::MAX_COUNT_OF_TEAMS);
    }
}
