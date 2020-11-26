<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Command;

use Psr\Container\ContainerInterface;
use Setono\Kraken\Client\Client;
use Setono\Kraken\Exception\RequestFailedException;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeConfiguredImageResources;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

final class OptimizeCommand extends Command implements ServiceSubscriberInterface
{
    use LockableTrait;

    /** @var string */
    protected static $defaultName = 'setono:sylius-image-optimizer:optimize';

    /** @var ContainerInterface */
    private $locator;

    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(ContainerInterface $locator, MessageBusInterface $commandBus)
    {
        parent::__construct();

        $this->locator = $locator;
        $this->commandBus = $commandBus;
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedServices(): array
    {
        return ['setono_kraken_io.client' => Client::class];
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

        $client = $this->locator->get('setono_kraken_io.client');

        try {
            $client->status();
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
