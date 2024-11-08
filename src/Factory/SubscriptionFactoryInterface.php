<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use VK\SyliusStripePaymentPlugin\Entity\OrderInterface;
use VK\SyliusStripePaymentPlugin\Entity\SubscriptionInterface;

interface SubscriptionFactoryInterface extends FactoryInterface
{
    public function createFromFirstOrder(OrderInterface $order): SubscriptionInterface;

    public function createFromFirstOrderWithOrderItemAndPaymentConfiguration(
        OrderInterface $order,
        OrderItemInterface $orderItem,
        array $paymentConfiguration = []
    ): SubscriptionInterface;
}
