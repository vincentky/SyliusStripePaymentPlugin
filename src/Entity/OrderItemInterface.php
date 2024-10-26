<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

interface OrderInterface extends BaseOrderInterface
{
    public function hasRecurringContents(): bool;

    public function hasNonRecurringContents(): bool;

    public function getSubscription(): ?SubscriptionInterface;

    public function setSubscription(?SubscriptionInterface $subscription): void;

    /** @return Collection|OrderItemInterface[] */
    public function getRecurringItems(): Collection;

    /** @return Collection|OrderItemInterface[] */
    public function getNonRecurringItems(): Collection;

}
