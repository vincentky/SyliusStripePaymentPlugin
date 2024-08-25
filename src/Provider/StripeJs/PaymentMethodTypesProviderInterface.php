<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider\StripeJs;

use Sylius\Component\Core\Model\PaymentInterface;

interface PaymentMethodTypesProviderInterface
{
    /**
     * @return string[]
     */
    public function getPaymentMethodTypes(PaymentInterface $payment): array;
}
