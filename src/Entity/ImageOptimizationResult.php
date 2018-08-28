<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Entity;

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

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOriginalBytes(): int
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
     * @return int
     */
    public function getOptimizedBytes(): int
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
     * @return int
     */
    public function getSavedBytes(): int
    {
        return $this->originalBytes - $this->optimizedBytes;
    }

    public function getSavedSensibleUnit($decimalPoint = '.'): string
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

            if($res > 1) {
                return number_format($res, 2, $decimalPoint).' '.$unit;
            }
        }

        return $savedBytes.' B';
    }

    /**
     * @return int
     */
    public function getSavedPercent(): int
    {
        return (int) floor($this->getSavedBytes() / $this->originalBytes * 100);
    }
}
