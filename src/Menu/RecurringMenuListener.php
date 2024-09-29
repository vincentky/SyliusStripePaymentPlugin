<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class RecurringMenuListener
{
    public function buildMenu(MenuBuilderEvent $menuBuilderEvent): void
    {
        $menu = $menuBuilderEvent->getMenu();
        $menuItem =
            $menu
                ->getChild('sales');

        if (null === $menuItem) {
            return;
        }

        $menuItem
            ->addChild('subscriptions', [
                'route' => 'sylius_stripe_payment_plugin_admin_subscription_index',
            ])
            ->setLabel('sylius_stripe_payment_plugin.ui.subscriptions')
            ->setLabelAttribute('icon', 'cart')
        ;
    }
}
