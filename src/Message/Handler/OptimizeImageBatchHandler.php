<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Handler;

use Setono\DoctrineORMBatcher\Query\QueryRebuilderInterface;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeImage;
use Setono\SyliusImageOptimizerPlugin\Message\Command\OptimizeImageBatch;
use Sylius\Component\Core\Model\ImageInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class OptimizeImageBatchHandler implements MessageHandlerInterface
{
    /** @var QueryRebuilderInterface */
    private $queryRebuilder;

    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(
        QueryRebuilderInterface $queryRebuilder,
        MessageBusInterface $commandBus
    ) {
        $this->queryRebuilder = $queryRebuilder;
        $this->commandBus = $commandBus;
    }

    public function __invoke(OptimizeImageBatch $message): void
    {
        $q = $this->queryRebuilder->rebuild($message->getBatch());

        /** @var ImageInterface[] $images */
        $images = $q->getResult();

        foreach ($images as $image) {
            $this->commandBus->dispatch(OptimizeImage::createFromImage($image, $message->getFilterSets()));
        }
    }
}
