<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use VK\PayumStripe\Request\Api\Resource\CustomCallInterface;

interface ExpireSessionRequestFactoryInterface
{
    public function createNew(string $id): CustomCallInterface;
}
