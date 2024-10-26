<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use VK\SyliusStripePaymentPlugin\Utility\StripeUtility;

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

        return StripeUtility::retrieveStepAndAmountFromInterval($value);
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
