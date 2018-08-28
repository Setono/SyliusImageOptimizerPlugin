<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Optimizer;

use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use Loevgaard\SyliusOptimizeImagesPlugin\Provider\OptimizationResult\AggregateOptimizationResult;
use Loevgaard\SyliusOptimizeImagesPlugin\Provider\OptimizationResult\AggregateOptimizationResultInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Provider\ProviderInterface;
use Loevgaard\SyliusOptimizeImagesPlugin\Resolver\PathResolver;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;

class ProductImageOptimizer implements OptimizerInterface
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
     * @var PathResolver
     */
    private $pathResolver;

    public function __construct(ProviderInterface $provider, ProductRepositoryInterface $productRepository, FilterConfiguration $filterConfiguration, PathResolver $pathResolver)
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
        ], [], 100);

        $aggregateOptimizationResult = new AggregateOptimizationResult();

        foreach ($products as $product) {
            foreach ($product->getImages() as $image) {
                foreach ($this->filterConfiguration->all() as $filterName => $filterConfig) {
                    $path = $this->pathResolver->resolve($image->getPath(), $filterName);
                    $optimizationResult = $this->provider->optimize(new \SplFileInfo($path));

                    $aggregateOptimizationResult->addOptimizationResult($optimizationResult);
                }
            }
        }

        return $aggregateOptimizationResult;
    }
}
