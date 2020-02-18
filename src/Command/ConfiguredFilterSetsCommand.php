<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ConfiguredFilterSetsCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'setono:sylius-image-optimizer:filter-sets';

    /** @var array */
    private $filterSets;

    public function __construct(array $filterSets)
    {
        parent::__construct();

        $this->filterSets = $filterSets;
    }

    protected function configure(): void
    {
        $this->setDescription('Outputs a list of configured filter sets');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->section('Configured filter sets');
        $io->listing(array_keys($this->filterSets));

        return 0;
    }
}
