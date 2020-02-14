<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Optimizer;

use Gaufrette\Filesystem;
use InvalidArgumentException;
use function Safe\sprintf;

abstract class Optimizer implements OptimizerInterface
{
    /** @var Filesystem */
    protected $filesystem;

    /** @var array */
    private $filterSetsConfiguration;

    public function __construct(Filesystem $filesystem, array $filterSetsConfiguration)
    {
        $this->filesystem = $filesystem;
        $this->filterSetsConfiguration = $filterSetsConfiguration;
    }

    protected function getFilterSetConfiguration(string $filterSet): array
    {
        if (!isset($this->filterSetsConfiguration[$filterSet])) {
            throw new InvalidArgumentException(sprintf('The filter set "%s" does not exist', $filterSet));
        }

        return $this->filterSetsConfiguration[$filterSet];
    }
}
