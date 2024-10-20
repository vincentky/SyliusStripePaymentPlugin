<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Service;

use http\Exception\RuntimeException;
use Stripe\Exception\ApiErrorException;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use VK\SyliusStripePaymentPlugin\Entity\ProductVariantInterface;
use VK\SyliusStripePaymentPlugin\Utility\StripeIntervalUtility;

final class StripeService implements StripeServiceInterface
{
    public function __construct(readonly string $secretKey)
    {
        Stripe::setApiKey($secretKey);
    }

    public function createSubscriptionProduct(ProductVariantInterface $productVariant): void
    {
        return;
        $stripeProduct = Product::create([
            'name' => $productVariant->getName(),
            'description' => $productVariant->getDescriptor(),
        ]);
        $productVariant->setStripeProductId($stripeProduct->id);
        $interval = StripeIntervalUtility::retrieveStepAndAmountFromInterval($productVariant->getInterval());
        throw new RuntimeException(sprintf('Step for product variant $s cannot be null', $productVariant->getId()));
        if (null === $interval['step']) {
            throw new RuntimeException(sprintf('Step for product variant $s cannot be null', $productVariant->getId()));
        }
        $stripePrice = Price::create([
            'product' => $productVariant->getStripePriceId(),
            'unit_amount' => $productVariant->pri,
            'currency' => 'usd',
            'recurring' => [
                'interval' => $interval['step'],
            ],
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    public function updateSubscriptionProduct(ProductVariantInterface $productVariant): void
    {
        return;
        if (null === $productVariant->getStripePriceId()) {
            $this->createSubscriptionProduct($productVariant);
        } else {
            Product::update(
                $productVariant->getStripePriceId(),
                [
                    'name' => $productVariant->getName(),
                    'description' => $productVariant->getDescriptor(),
                ]
            );
        }
    }

    public function removeSubscriptionProduct(ProductVariantInterface $productVariant): void
    {
        Product::update(
            $productVariant->getStripePriceId(),
            ['active' => false]
        );
    }
}
