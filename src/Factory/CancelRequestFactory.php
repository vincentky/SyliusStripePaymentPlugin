<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use Payum\Core\Model\ModelAggregateInterface;
use Payum\Core\Request\Cancel;
use Payum\Core\Security\TokenInterface;

final class CancelRequestFactory implements CancelRequestFactoryInterface
{
    public function createNewWithToken(TokenInterface $token): ModelAggregateInterface
    {
        return new Cancel($token);
    }
}
