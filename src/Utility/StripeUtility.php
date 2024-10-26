<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Utility;

use VK\SyliusStripePaymentPlugin\Entity\SubscriptionConfigurationInterface;

class StripeIntervalUtility
{
    public static function retrieveStepAndAmountFromInterval(string $interval): array
    {

        preg_match(
            sprintf(
                '/^(?<amount>\d{1,})\s(?<step>%s)$/',
                implode('|', SubscriptionConfigurationInterface::SUPPORTED_INTERVAL_STEPS)
            ),
            $interval,
            $matches
        );

        return empty($matches) ? [
            'amount' => null,
            'step' => null,
        ] : $matches;
    }
}
