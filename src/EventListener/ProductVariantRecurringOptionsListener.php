<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\EventListener;

use Sylius\Bundle\AdminBundle\Event\ProductVariantMenuBuilderEvent;

final class ProductVariantRecurringOptionsListener
{
    public function addRecurringOptionsMenu(ProductVariantMenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $menu
            ->addChild('recurring')
            ->setAttribute('template', '@SyliusStripePaymentPlugin/Admin/ProductVariant/Tab/_recurring.html.twig')
            ->setLabel('sylius_stripe_payment_plugin.ui.product_variant.tab.recurring');
    }
}
