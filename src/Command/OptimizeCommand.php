<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Command;

use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeConfiguredImageResources;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class OptimizeCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'setono:sylius-image-optimizer:optimize';

    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this->setDescription('This command will trigger the optimization of your configured image resources');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(new OptimizeConfiguredImageResources());

        return 0;
    }
}
