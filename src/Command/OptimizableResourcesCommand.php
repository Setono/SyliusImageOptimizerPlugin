<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Command;

use Sylius\Component\Core\Model\ImageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class OptimizableResourcesCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'setono:sylius-image-optimizer:optimizable-resources';

    /** @var array */
    private $resources;

    public function __construct(array $resources)
    {
        parent::__construct();

        $this->resources = $resources;
    }

    protected function configure(): void
    {
        $this->setDescription('Outputs a list of optimizable Sylius resources');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $optimizableResources = [];

        foreach ($this->resources as $resource => $config) {
            if (!isset($config['classes']['model'])) {
                continue;
            }

            if (!is_a($config['classes']['model'], ImageInterface::class, true)) {
                continue;
            }

            $optimizableResources[] = $resource;
        }

        $io->section('Optimizable resources');
        $io->listing($optimizableResources);

        return 0;
    }
}
