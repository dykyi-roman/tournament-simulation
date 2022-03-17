<?php

declare(strict_types=1);

namespace TS\Components\Tournament\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

abstract class AbstractCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->validateInput($input);

        $name = (string) $this->getName();

        ($io = new SymfonyStyle($input, $output))->title($this->getDescription());

        ($stopwatch = new Stopwatch())->start($name);

        $this->doExecute($input, $io);

        $event = $stopwatch->stop($name);

        $io->newLine();
        $io->success(
            sprintf(
                'Done in %.3f seconds, %.3f MB memory used.',
                $event->getDuration() / 1000,
                $event->getMemory() / 1024 / 1024
            )
        );

        return Command::SUCCESS;
    }

    abstract protected function doExecute(InputInterface $input, SymfonyStyle $io): void;

    protected function validateInput(InputInterface $input): void
    {
    }
}
