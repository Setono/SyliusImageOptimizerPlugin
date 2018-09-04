<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Entity;

use Loevgaard\SyliusOptimizeImagesPlugin\Optimizer\OptimizerInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

class ImageOptimizationResult implements ResourceInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $optimizer;

    /**
     * @var int
     */
    protected $originalBytes;

    /**
     * @var int
     */
    protected $optimizedBytes;

    public function __construct()
    {
        $this->originalBytes = 0;
        $this->optimizedBytes = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOptimizer(): ?string
    {
        return $this->optimizer;
    }

    /**
     * @param string|OptimizerInterface $optimizer
     */
    public function setOptimizer($optimizer): void
    {
        if ($optimizer instanceof OptimizerInterface) {
            $optimizer = $optimizer->getCode();
        }

        if (!is_string($optimizer)) {
            throw new \InvalidArgumentException('$optimizer must be a string');
        }

        $this->optimizer = $optimizer;
    }

    /**
     * @return int
     */
    public function getOriginalBytes(): ?int
    {
        return $this->originalBytes;
    }

    /**
     * @param int $originalBytes
     */
    public function setOriginalBytes(int $originalBytes): void
    {
        $this->originalBytes = $originalBytes;
    }

    /**
     * Adds to the original bytes
     *
     * @param int $originalBytes
     */
    public function addOriginalBytes(int $originalBytes): void
    {
        $this->originalBytes += $originalBytes;
    }

    /**
     * @return int
     */
    public function getOptimizedBytes(): ?int
    {
        return $this->optimizedBytes;
    }

    /**
     * @param int $optimizedBytes
     */
    public function setOptimizedBytes(int $optimizedBytes): void
    {
        $this->optimizedBytes = $optimizedBytes;
    }

    /**
     * Adds to the optimized bytes
     *
     * @param int $optimizedBytes
     */
    public function addOptimizedBytes(int $optimizedBytes): void
    {
        $this->optimizedBytes += $optimizedBytes;
    }

    /**
     * Number of bytes saved between the original bytes and the optimized bytes
     *
     * @return int
     */
    public function getSavedBytes(): int
    {
        return (int) $this->getOriginalBytes() - (int) $this->getOptimizedBytes();
    }

    /**
     * Returns a sensible unit on the number of bytes saved for this optimizer, i.e. 1.34 GB
     *
     * @param string $decimalPoint
     * @param string $thousandsSeparator
     *
     * @return string
     */
    public function getSavedSensibleUnit(string $decimalPoint = '.', string $thousandsSeparator = ','): string
    {
        $savedBytes = $this->getSavedBytes();

        $units = [
            'TB' => 1099511627776,
            'GB' => 1073741824,
            'MB' => 1048576,
            'KB' => 1024,
        ];

        foreach ($units as $unit => $divisor) {
            $res = $savedBytes / $divisor;

            if ($res > 1) {
                return number_format($res, 2, $decimalPoint, $thousandsSeparator) . ' ' . $unit;
            }
        }

        return $savedBytes . ' B';
    }

    /**
     * Returns a string representing how many percent that has been saved for this optimizer, i.e. 23%
     *
     * @return string
     */
    public function getSavedPercent(): string
    {
        $originalBytes = (int) $this->getOriginalBytes();
        $savedPercent = 0;

        if ($originalBytes > 0) {
            $savedPercent = floor($this->getSavedBytes() / $this->getOriginalBytes() * 100);
        }

        return $savedPercent . '%';
    }
}
