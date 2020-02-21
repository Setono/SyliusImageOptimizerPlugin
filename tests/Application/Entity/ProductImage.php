<?php
declare(strict_types=1);

namespace Tests\Setono\SyliusImageOptimizerPlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Setono\SyliusImageOptimizerPlugin\Model\OptimizableInterface;
use Setono\SyliusImageOptimizerPlugin\Model\OptimizableTrait;
use Sylius\Component\Core\Model\ProductImage as BaseProductImage;

/**
 * @ORM\Table(name="sylius_product_image")
 * @ORM\Entity()
 */
final class ProductImage extends BaseProductImage implements OptimizableInterface
{
    use OptimizableTrait;
}
