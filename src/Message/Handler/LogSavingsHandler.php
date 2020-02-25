<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Handler;

use Setono\SyliusImageOptimizerPlugin\Message\Event\ImageFileOptimized;
use Setono\SyliusImageOptimizerPlugin\Model\SavingsInterface;
use Setono\SyliusImageOptimizerPlugin\Repository\SavingsRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class LogSavingsHandler implements MessageHandlerInterface
{
    /** @var FactoryInterface */
    private $savingsFactory;

    /** @var SavingsRepositoryInterface */
    private $savingsRepository;

    public function __construct(FactoryInterface $savingsFactory, SavingsRepositoryInterface $savingsRepository)
    {
        $this->savingsFactory = $savingsFactory;
        $this->savingsRepository = $savingsRepository;
    }

    public function __invoke(ImageFileOptimized $message): void
    {
        /** @var SavingsInterface $savings */
        $savings = $this->savingsFactory->createNew();
        $savings->setImageResource($message->getImageResource());
        $savings->setOriginalSize($message->getOptimizationResult()->getOriginalSize());
        $savings->setOptimizedSize($message->getOptimizationResult()->getOptimizedSize());

        $this->savingsRepository->add($savings);
    }
}
