<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use VK\PayumStripe\Request\Api\Resource\CancelPaymentIntent;
use VK\PayumStripe\Request\Api\Resource\CustomCallInterface;

final class CancelPaymentIntentRequestFactory implements CancelPaymentIntentRequestFactoryInterface
{
    public function createNew(string $id): CustomCallInterface
    {
        return new CancelPaymentIntent($id);
    }
}
