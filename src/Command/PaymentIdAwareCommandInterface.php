<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Command;

interface PaymentIdAwareCommandInterface
{
    public function getPaymentId(): int;
}
