<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use Payum\Core\Model\ModelAggregateInterface;
use Payum\Core\Security\TokenInterface;

interface RefundRequestFactoryInterface
{
    public function createNewWithToken(TokenInterface $token): ModelAggregateInterface;
}
