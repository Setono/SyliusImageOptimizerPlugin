<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
use Setono\DoctrineORMBatcher\Factory\BatcherFactoryInterface;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeImageBatch;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeImageResource;
use Sylius\Component\Resource\Metadata\Registry;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class OptimizeImageResourceHandler implements MessageHandlerInterface
{
    /** @var ManagerRegistry */
    private $managerRegistry;

    /** @var Registry */
    private $resourceRegistry;

    /** @var BatcherFactoryInterface */
    private $batcherFactory;

    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(
        ManagerRegistry $managerRegistry,
        Registry $resourceRegistry,
        BatcherFactoryInterface $batcherFactory,
        MessageBusInterface $commandBus
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->resourceRegistry = $resourceRegistry;
        $this->batcherFactory = $batcherFactory;
        $this->commandBus = $commandBus;
    }

    public function __invoke(OptimizeImageResource $message): void
    {
        try {
            $resource = $this->resourceRegistry->get($message->getImageResource());
        } catch (InvalidArgumentException $e) {
            throw new UnrecoverableMessageHandlingException($e->getMessage());
        }

        $class = $resource->getClass('model');
        $manager = $this->getManager($class);

        $qb = $manager->createQueryBuilder()
            ->select('o')
            ->from($class, 'o')
            ->andWhere('o.optimized = false')
        ;

        $batcher = $this->batcherFactory->createIdCollectionBatcher($qb);

        foreach ($batcher->getBatches() as $batch) {
            $this->commandBus->dispatch(new OptimizeImageBatch($batch, $message->getFilterSets()));
        }
    }

    private function getManager(string $class): EntityManagerInterface
    {
        /** @var EntityManagerInterface $manager */
        $manager = $this->managerRegistry->getManagerForClass($class);

        return $manager;
    }
}
