<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Service;

use VK\SyliusStripePaymentPlugin\Entity\OrderItemInterface;
use VK\SyliusStripePaymentPlugin\Entity\ProductVariantInterface;

interface StripeServiceInterface
{
    public const SUPPORTED_INTERVAL_STEPS = [
        'day',
        'week',
        'month',
    ];

    public function createSubscriptionProduct(ProductVariantInterface $productVariant): void;

    public function updateSubscriptionProduct(ProductVariantInterface $productVariant): void;

    public function removeSubscriptionProduct(ProductVariantInterface $productVariant): void;

    public function retrievePriceId(OrderItemInterface $orderItem): ?string;
}
