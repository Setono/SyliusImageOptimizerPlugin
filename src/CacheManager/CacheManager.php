<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\CacheManager;

use Liip\ImagineBundle\Imagine\Cache\CacheManager as BaseCacheManager;
use Liip\ImagineBundle\Imagine\Cache\SignerInterface;
use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final class CacheManager extends BaseCacheManager
{
    /** @var RequestStack */
    private $requestStack;

    public function __construct(
        FilterConfiguration $filterConfig,
        RouterInterface $router,
        SignerInterface $signer,
        EventDispatcherInterface $dispatcher,
        RequestStack $requestStack,
        $defaultResolver = null
    ) {
        parent::__construct($filterConfig, $router, $signer, $dispatcher, $defaultResolver);

        $this->requestStack = $requestStack;
    }

    public function getBrowserPath($path, $filter, array $runtimeConfig = [], $resolver = null, $referenceType = UrlGeneratorInterface::ABSOLUTE_URL): string
    {
        if ($this->clientAcceptsWebP()) {
            $webPPath = self::getWebPPath($path);
            if ($this->isStored($webPPath, $filter, $resolver)) {
                $path = $webPPath;
            }
        }

        return parent::getBrowserPath($path, $filter, $runtimeConfig, $resolver);
    }

    private static function getWebPPath(string $path): string
    {
        $pathInfo = pathinfo($path);

        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
    }

    private function clientAcceptsWebP(): bool
    {
        $request = $this->requestStack->getMasterRequest();
        if (null === $request) {
            return false;
        }

        return in_array('image/webp', $request->getAcceptableContentTypes(), true);
    }
}
