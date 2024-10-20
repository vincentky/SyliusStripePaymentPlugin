<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Service;

use VK\SyliusStripePaymentPlugin\Entity\ProductVariantInterface;

interface StripeServiceInterface
{
    public function createSubscriptionProduct(ProductVariantInterface $productVariant): void;

    public function updateSubscriptionProduct(ProductVariantInterface $productVariant): void;

    public function removeSubscriptionProduct(ProductVariantInterface $productVariant): void;
}
