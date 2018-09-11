<?php

declare(strict_types=1);

namespace Setono\SyliusOptimizeImagesPlugin\Imagine\Filter\PostProcessor;

use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Imagine\Filter\PostProcessor\PostProcessorInterface;
use Liip\ImagineBundle\Model\Binary;
use Setono\TinyPngBundle\Client\ClientInterface as TinyPngClientInterface;

class TinyPngPostProcessor implements PostProcessorInterface
{
    /**
     * @var TinyPngClientInterface
     */
    private $client;

    /**
     * @param TinyPngClientInterface $client
     */
    public function __construct(TinyPngClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * This method takes the binary, passes it to TinyPNG through the TinyPNG bundle and returns a new binary with the compressed image string
     *
     * @param BinaryInterface $binary
     * @param array $options
     *
     * @return BinaryInterface
     */
    public function process(BinaryInterface $binary, array $options = []): BinaryInterface
    {
        return new Binary($this->client->compressBuffer($binary->getContent()), $binary->getMimeType(), $binary->getFormat());
    }
}
