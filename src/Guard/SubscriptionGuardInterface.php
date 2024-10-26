<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Guard;

use VK\SyliusStripePaymentPlugin\Entity\SubscriptionInterface;

interface SubscriptionGuardInterface
{
    public function isCompletable(SubscriptionInterface $subscription): bool;
}
