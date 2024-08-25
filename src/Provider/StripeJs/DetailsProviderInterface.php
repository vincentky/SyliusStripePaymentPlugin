<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider\StripeJs;

use Sylius\Component\Core\Model\PaymentInterface;

interface DetailsProviderInterface
{
    public function getDetails(PaymentInterface $payment): array;
}
