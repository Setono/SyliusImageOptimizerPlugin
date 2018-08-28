<?php

declare(strict_types=1);

namespace Loevgaard\SyliusOptimizeImagesPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $catalog = $menu->getChild('catalog');

        if ($catalog) {
            $this->addChild($catalog);
        } else {
            $this->addChild($menu->getFirstChild());
        }
    }

    private function addChild(ItemInterface $item): void
    {
        $item
            ->addChild('image_optimization_results', [
                'route' => 'loevgaard_sylius_optimize_images_admin_image_optimization_result_index',
            ])
            ->setLabel('loevgaard_sylius_optimize_images.ui.image_optimization_results')
            ->setLabelAttribute('icon', 'tachometer alternate');
    }
}
