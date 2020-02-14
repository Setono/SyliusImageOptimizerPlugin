<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Handler;

use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeConfiguredImageResources;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeImageResource;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class OptimizeConfiguredImageResourcesHandler implements MessageHandlerInterface
{
    /** @var MessageBusInterface */
    private $commandBus;

    /** @var array */
    private $imageResourcesConfig;

    public function __construct(MessageBusInterface $commandBus, array $imageResourcesConfig)
    {
        $this->commandBus = $commandBus;
        $this->imageResourcesConfig = $imageResourcesConfig;
    }

    public function __invoke(OptimizeConfiguredImageResources $message): void
    {
        foreach ($this->imageResourcesConfig as $imageResource => $filterSets) {
            $this->commandBus->dispatch(new OptimizeImageResource($imageResource, $filterSets));
        }
    }
}
