<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use VK\PayumStripe\Request\Api\Resource\CustomCallInterface;
use VK\PayumStripe\Request\Api\Resource\ExpireSession;

final class ExpireSessionRequestFactory implements ExpireSessionRequestFactoryInterface
{
    public function createNew(string $id): CustomCallInterface
    {
        return new ExpireSession($id);
    }
}
