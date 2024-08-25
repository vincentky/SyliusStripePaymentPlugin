<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use VK\PayumStripe\Request\Api\Resource\AllInterface;
use VK\PayumStripe\Request\Api\Resource\AllSession;

final class AllSessionRequestFactory implements AllSessionRequestFactoryInterface
{
    public function createNew(): AllInterface
    {
        return new AllSession();
    }
}
