<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Command;

use Loevgaard\SyliusOptimizeImagesPlugin\Optimizer\OptimizerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OptimizeCommand extends Command
{
    /**
     * @var OptimizerInterface[]
     */
    private $optimizers;

    public function __construct(OptimizerInterface...$optimizers)
    {
        parent::__construct();

        $this->optimizers = $optimizers;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('loevgaard:sylius-optimize-images:optimize')
            ->setDescription('This command will optimize your product images')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->optimizers as $optimizer) {
            $optimizer->optimize();
        }
    }
}
