<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider;

use Sylius\Component\Core\Model\OrderItemInterface;

interface LinetItemNameProviderInterface
{
    public function getItemName(OrderItemInterface $orderItem): string;
}
