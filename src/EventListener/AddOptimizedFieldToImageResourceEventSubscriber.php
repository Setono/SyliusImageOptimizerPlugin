<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\MappingException;
use Setono\SyliusImageOptimizerPlugin\Model\OptimizableInterface;

final class AddOptimizedFieldToImageResourceEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [Events::loadClassMetadata];
    }

    /**
     * @throws MappingException
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $event): void
    {
        $classMetadata = $event->getClassMetadata();
        $class = $classMetadata->getName();
        if (!is_a($class, OptimizableInterface::class, true)) {
            return;
        }

        $classMetadata->mapField([
            'fieldName' => 'optimized',
            'type' => 'boolean',
            'options' => [
                'default' => 0,
            ],
        ]);

        $classMetadata->table = array_merge_recursive([
            'indexes' => [
                [
                    'columns' => [
                        'optimized',
                    ],
                ],
            ],
        ], $classMetadata->table);
    }
}
