<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Factory;

use const PHP_URL_PATH;
use function Safe\parse_url;
use Setono\SyliusImageOptimizerPlugin\ImageFile\ImageFile;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class NgrokAwareImageFileFactory implements ImageFileFactoryInterface
{
    /** @var ImageFileFactoryInterface */
    private $decoratedImageFileFactory;

    /** @var HttpClientInterface */
    private $httpClient;

    public function __construct(ImageFileFactoryInterface $decoratedImageFileFactory, HttpClientInterface $httpClient)
    {
        $this->decoratedImageFileFactory = $decoratedImageFileFactory;
        $this->httpClient = $httpClient;
    }

    public function createFromUrl(string $url): ImageFile
    {
        try {
            $response = $this->httpClient->request('GET', 'http://127.0.0.1:4040/api/tunnels');
            $data = $response->toArray();

            if (!isset($data['tunnels'][0]['public_url'])) {
                return $this->decoratedImageFileFactory->createFromUrl($url);
            }

            $ngrokUrl = $data['tunnels'][0]['public_url'];

            return new ImageFile($ngrokUrl . parse_url($url, PHP_URL_PATH));
        } catch (ExceptionInterface $e) {
            // no matter what exception we get from the http client
            // we will just fallback to the decorated image file factory
            return $this->decoratedImageFileFactory->createFromUrl($url);
        }
    }
}
