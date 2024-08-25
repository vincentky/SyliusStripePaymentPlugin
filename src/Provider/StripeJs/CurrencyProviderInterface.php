<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider\StripeJs;

use Sylius\Component\Core\Model\PaymentInterface;

interface CurrencyProviderInterface
{
    public function getCurrency(PaymentInterface $payment): string;
}
