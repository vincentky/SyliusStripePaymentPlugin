<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderItemInterface;

trait RecurringOrderTrait
{
    #[ORM\ManyToOne(targetEntity: SubscriptionInterface::class)]
    #[ORM\JoinColumn(name: 'subscription_id', referencedColumnName: 'id', onDelete: 'RESTRICT')]
    protected ?SubscriptionInterface $subscription = null;

    public function getSubscription(): ?SubscriptionInterface
    {
        return $this->subscription;
    }

    public function setSubscription(?SubscriptionInterface $subscription): void
    {
        $this->subscription = $subscription;
    }

    public function getRecurringItems(): Collection
    {
        return $this
            ->items
            ->filter(function (OrderItemInterface $orderItem) {
                $variant = $orderItem->getVariant();

                return $variant !== null &&
                    true === $variant->isRecurring();
            });
    }

    public function getNonRecurringItems(): Collection
    {
        return $this
            ->items
            ->filter(function (OrderItemInterface $orderItem) {
                $variant = $orderItem->getVariant();

                return $variant !== null &&
                    false === $variant->isRecurring();
            });
    }

    public function hasRecurringContents(): bool
    {
        return 0 < $this->getRecurringItems()->count();
    }

    public function hasNonRecurringContents(): bool
    {
        return 0 < $this->getNonRecurringItems()->count();
    }
}
