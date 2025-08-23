<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:showcase-output')]
class OutputShowcaseCommand extends Command
{
    protected function configure(): void {
        $this
            ->addArgument(
                name: 'listitems',
                mode: InputArgument::IS_ARRAY,
                description: 'Items you want to list; space separated.',
                default: ['one', 'two', 'three']
            );
    }
    public function __invoke(
        InputInterface $input,
        SymfonyStyle $io
    ): int
    {
        $items = $input->getArgument('listitems');

        $io->title('Output Showcase');
        $io->section('Output formats:');
        $io->writeln('A simple string: Hello World!');

        $io->writeln('Listings:');
        $this->customListing($items, $io);

        $io->writeln('Tables:');
        $io->table(
            ['Header 1', 'Header 2'],
            [
                ['Cell 1-1', 'Cell 1-2'],
                ['Cell 2-1', 'Cell 2-2'],
                ['Cell 3-1', 'Cell 3-2'],
            ]
        );

        $io->writeln('Horizontal table:');
        $io->horizontalTable(
            ['Header 1', 'Header 2'],
            [
                ['Cell 1-1', 'Cell 1-2'],
                ['Cell 2-1', 'Cell 2-2'],
                ['Cell 3-1', 'Cell 3-2'],
            ]
        );

        $io->writeln('Definition List:');
        $io->definitionList(
            'This is a title',
            ['foo1' => 'bar1'],
            ['foo2' => 'bar2'],
            ['foo3' => 'bar3'],
            new TableSeparator(),
            'This is another title',
            ['foo4' => 'bar4']
        );

        return Command::SUCCESS;
    }

    /**
     * @param array<string> $items
     */
    private function customListing(array $items, SymfonyStyle $io): void {
        $io->listing($items);
    }

}