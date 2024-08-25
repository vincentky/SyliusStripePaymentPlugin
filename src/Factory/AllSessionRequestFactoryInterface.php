<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use VK\PayumStripe\Request\Api\Resource\AllInterface;

interface AllSessionRequestFactoryInterface
{
    public function createNew(): AllInterface;
}
