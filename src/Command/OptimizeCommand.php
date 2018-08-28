<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Command;

use Loevgaard\SyliusOptimizeImagesPlugin\Runner\RunnerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OptimizeCommand extends Command
{
    /**
     * @var RunnerInterface
     */
    private $runner;

    public function __construct(RunnerInterface $runner)
    {
        parent::__construct();

        $this->runner = $runner;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('loevgaard:sylius-optimize-images:optimize')
            ->setDescription('This command will optimize your images')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->runner->run();
    }
}
