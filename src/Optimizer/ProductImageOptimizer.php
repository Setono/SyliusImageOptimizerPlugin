<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Optimizer;

use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\AggregateOptimizationResult;
use Loevgaard\SyliusOptimizeImagesPlugin\OptimizationResult\AggregateOptimizationResultInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Provider\ProviderInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Resolver\PathResolverInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;

class ProductImageOptimizer extends Optimizer
{
    /**
     * @var ProviderInterface
     */
    private $provider;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var FilterConfiguration
     */
    private $filterConfiguration;

    /**
     * @var PathResolverInterface
     */
    private $pathResolver;

    public function __construct(ProviderInterface $provider, ProductRepositoryInterface $productRepository, FilterConfiguration $filterConfiguration, PathResolverInterface $pathResolver)
    {
        $this->provider = $provider;
        $this->productRepository = $productRepository;
        $this->filterConfiguration = $filterConfiguration;
        $this->pathResolver = $pathResolver;
    }

    public function optimize(): AggregateOptimizationResultInterface
    {
        /** @var ProductInterface[] $products */
        $products = $this->productRepository->findBy([
            //'imagesOptimized' => null
        ], []);

        $aggregateOptimizationResult = new AggregateOptimizationResult();

        foreach ($products as $product) {
            foreach ($product->getImages() as $image) {
                foreach ($this->filterConfiguration->all() as $filterName => $filterConfig) {
                    $path = $this->pathResolver->resolve($image->getPath(), $filterName);
                    $file = new \SplFileInfo($path);

                    if (!$file->isFile()) {
                        continue;
                    }

                    $optimizationResult = $this->provider->optimize($file);

                    $aggregateOptimizationResult->addOptimizationResult($optimizationResult);
                }
            }
        }

        return $aggregateOptimizationResult;
    }
}
