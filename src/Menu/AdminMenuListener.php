<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $submenu = $menu->getChild('catalog');
        if ($submenu instanceof ItemInterface) {
            $this->addChild($submenu);
        } else {
            $this->addChild($menu->getFirstChild());
        }
    }

    private function addChild(ItemInterface $item): void
    {
        $item
            ->addChild('image_optimizer', [
                'route' => 'setono_sylius_image_optimizer_admin_image_optimizer_index',
            ])
            ->setLabel('setono_sylius_image_optimizer.ui.image_optimizer')
            ->setLabelAttribute('icon', 'chart line')
        ;
    }
}
