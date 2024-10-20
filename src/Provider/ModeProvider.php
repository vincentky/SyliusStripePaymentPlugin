<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider;

use Stripe\Checkout\Session;
use VK\SyliusStripePaymentPlugin\Entity\OrderInterface;

final class ModeProvider implements ModeProviderInterface
{
    public function getMode(OrderInterface $order): string
    {
        return $order->hasRecurringContents() ? Session::MODE_SUBSCRIPTION : Session::MODE_PAYMENT;
    }
}
