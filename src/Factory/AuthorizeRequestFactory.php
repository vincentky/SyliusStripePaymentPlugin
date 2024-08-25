<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use Payum\Core\Model\ModelAggregateInterface;
use Payum\Core\Request\Authorize;
use Payum\Core\Security\TokenInterface;

final class AuthorizeRequestFactory implements ModelAggregateFactoryInterface
{
    public function createNewWithToken(TokenInterface $token): ModelAggregateInterface
    {
        return new Authorize($token);
    }
}
