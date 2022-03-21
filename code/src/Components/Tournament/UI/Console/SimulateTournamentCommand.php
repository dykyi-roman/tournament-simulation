<?php

declare(strict_types=1);

namespace TS\Components\Tournament\UI\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use TS\Components\Tournament\Application\Command\AbstractCommand;
use TS\Components\Tournament\Application\Simulate\Message\SimulateTournamentMatchCommand;
use TS\Components\Tournament\Features\Simulate\TournamentFinishException;
use TS\Components\Tournament\Features\Simulate\TournamentNotFoundException;
use Webmozart\Assert\Assert;

final class SimulateTournamentCommand extends AbstractCommand
{
    protected static $defaultName = 'ts:simulate-tournament';

    public function __construct(private MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    protected function doExecute(InputInterface $input, SymfonyStyle $io): void
    {
        $tournamentName = (string) $input->getArgument('tournament-name');

        try {
            $this->messageBus->dispatch(
                new SimulateTournamentMatchCommand($tournamentName)
            );
        } catch (TournamentFinishException) {
            $io->error(sprintf('Tournament with name "%s" is finished.', $tournamentName));
        } catch (TournamentNotFoundException) {
            $io->error(sprintf('Tournament with name "%s" not found.', $tournamentName));
        }
    }

    protected function configure(): void
    {
        $this->setHelp('This command play a tournament match by name.')->addArgument(
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
