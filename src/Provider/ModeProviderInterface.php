<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider;

use Sylius\Component\Core\Model\OrderInterface;

interface ModeProviderInterface
{
    public function getMode(OrderInterface $order): string;
}
