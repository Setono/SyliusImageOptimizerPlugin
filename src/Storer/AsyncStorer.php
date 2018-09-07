<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Storer;

use Enqueue\Client\ProducerInterface;
use Liip\ImagineBundle\Async\Commands;
use Liip\ImagineBundle\Async\ResolveCache;

class AsyncStorer implements StorerInterface
{
    /**
     * @var ProducerInterface
     */
    private $producer;

    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
    }

    /**
     * @inheritdoc
     */
    public function store(string $path, string $filter): void
    {
        $this->producer->sendCommand(Commands::RESOLVE_CACHE, new ResolveCache($path, [$filter]));
    }
}
