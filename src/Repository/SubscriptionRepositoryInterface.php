<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Repository;

use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use VK\SyliusStripePaymentPlugin\Entity\SubscriptionInterface;

interface SubscriptionRepositoryInterface extends RepositoryInterface
{
    public function findOneByOrderId(int $orderId): ?SubscriptionInterface;

    /** @return SubscriptionInterface[] */
    public function findByOrderId(int $orderId): array;

    /** @return SubscriptionInterface[] */
    public function findByPayment(PaymentInterface $payment): array;

    /** @return SubscriptionInterface[] */
    public function findScheduledSubscriptions(): array;

    /** @return SubscriptionInterface[] */
    public function findProcessableSubscriptions(): array;

    public function findOneByOrderIdAsString(string $orderId): ?SubscriptionInterface;
}
