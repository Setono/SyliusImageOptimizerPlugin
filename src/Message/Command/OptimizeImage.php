<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Message\Command;

use Sylius\Component\Core\Model\ImageInterface;

final class OptimizeImage implements CommandInterface
{
    /** @var string */
    private $imageResource;

    /** @var string */
    private $class;

    /** @var mixed */
    private $id;

    /** @var string */
    private $path;

    /** @var array */
    private $filterSets;

    /**
     * @param mixed $id
     */
    public function __construct(string $imageResource, string $class, $id, string $path, array $filterSets)
    {
        $this->imageResource = $imageResource;
        $this->class = $class;
        $this->id = $id;
        $this->path = $path;
        $this->filterSets = $filterSets;
    }

    public static function createFromImage(string $imageResource, ImageInterface $image, array $filterSets): self
    {
        return new self($imageResource, get_class($image), $image->getId(), $image->getPath(), $filterSets);
    }

    public function getImageResource(): string
    {
        return $this->imageResource;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilterSets(): array
    {
        return $this->filterSets;
    }
}
