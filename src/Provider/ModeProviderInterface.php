<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider;

use VK\SyliusStripePaymentPlugin\Entity\OrderInterface;

interface ModeProviderInterface
{
    public function getMode(OrderInterface $order): string;
}
