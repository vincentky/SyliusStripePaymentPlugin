<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use VK\SyliusStripePaymentPlugin\Entity\SubscriptionConfigurationInterface;

final class StripeIntervalTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (false === is_string($value)) {
            return [
                'amount' => null,
                'step' => null,
            ];
        }

        preg_match(
            sprintf(
                '/^(?<amount>\d{1,})\s(?<step>%s)$/',
                implode('|', SubscriptionConfigurationInterface::SUPPORTED_INTERVAL_STEPS)
            ),
            $value,
            $matches
        );

        return $matches;
    }

    public function reverseTransform($value)
    {
        if (false === is_array($value)) {
            return null;
        }

        if (false === array_key_exists('amount', $value) || false === array_key_exists('step', $value)) {
            return null;
        }

        return sprintf('%d %s', $value['amount'], $value['step']);
    }
}
