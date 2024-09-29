<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

trait RecurringOrderTrait
{
    protected ?SubscriptionInterface $subscription = null;

    public function getSubscription(): ?SubscriptionInterface
    {
        return $this->subscription;
    }

    public function setSubscription(?SubscriptionInterface $subscription): void
    {
        $this->subscription = $subscription;
    }
}
