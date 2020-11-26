<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Command;

use Setono\Kraken\Client\ClientInterface;
use Setono\Kraken\Exception\RequestFailedException;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeConfiguredImageResources;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class OptimizeCommand extends Command
{
    use LockableTrait;

    /** @var string */
    protected static $defaultName = 'setono:sylius-image-optimizer:optimize';

    /** @var ClientInterface */
    private $client;

    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(ClientInterface $client, MessageBusInterface $commandBus)
    {
        parent::__construct();

        $this->client = $client;
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this->setDescription('This command will trigger the optimization of your configured image resources');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return 0;
        }

        try {
            $this->client->status();
        } catch (RequestFailedException $e) {
            $output->writeln('<error>An error occurred when trying to ping the Kraken API:</error>');
            $output->writeln('<error>- ' . $e->getMessage() . '</error>');
            $output->writeln('<comment>Usually this is because of a wrong API key or API secret</comment>');

            return 1;
        }

        $this->commandBus->dispatch(new OptimizeConfiguredImageResources());

        return 0;
    }
}
