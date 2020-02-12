<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusImageOptimizerPlugin\Imagine\Filter\PostProcessor;

use Liip\ImagineBundle\Model\Binary;
use PHPUnit\Framework\TestCase;
use Setono\SyliusImageOptimizerPlugin\Imagine\Filter\PostProcessor\TinyPngPostProcessor;
use Setono\TinyPngBundle\Client\ClientInterface;

class TinyPngPostProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function processReturnsNewBinary(): void
    {
        /** @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject $client */
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();

        $client->method('compressBuffer')->with('test')->willReturn('test');

        $binary = new Binary('test', 'test');

        $processor = new TinyPngPostProcessor($client);
        $newBinary = $processor->process($binary);

        $this->assertNotSame($binary, $newBinary);
    }
}
