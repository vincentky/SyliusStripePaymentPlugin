<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

use Sylius\Component\Core\Model\OrderItemInterface as BaseOrderItemInterface;

interface OrderItemInterface extends BaseOrderItemInterface
{
    public function getStripePriceId(): ?string;

    public function setStripePriceId(?string $stripePriceId): void;
}
