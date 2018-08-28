<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Resolver;

class PathResolver
{
    /**
     * @var array
     */
    private $resolvers;

    public function __construct(array $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    public function resolve(string $path, string $filter): string
    {
        return $this->resolvers['default']['web_path']['web_root'].'/'.$this->resolvers['default']['web_path']['cache_prefix'].'/'.$filter.'/'.ltrim($path, '/');
    }
}
