<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider;

use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;

interface LineItemImagesProviderInterface
{
    /**
     * @return string[]
     */
    public function getImageUrls(OrderItemInterface $orderItem): array;

    public function getImageUrlFromProduct(ProductInterface $product): string;
}
