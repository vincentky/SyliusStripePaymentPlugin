<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Service;

use Stripe\Exception\ApiErrorException;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use Sylius\Component\Core\Model\OrderInterface;
use VK\SyliusStripePaymentPlugin\Entity\OrderItemInterface;
use VK\SyliusStripePaymentPlugin\Entity\ProductVariantInterface;
use VK\SyliusStripePaymentPlugin\Utility\StripeUtility;

final class StripeService implements StripeServiceInterface
{
    public function __construct(readonly string $secretKey)
    {
        Stripe::setApiKey($secretKey);
    }

    /**
     * @throws ApiErrorException
     */
    public function createSubscriptionProduct(ProductVariantInterface $productVariant): void
    {
        if (!$productVariant->isRecurring()) {
            return;
        }
        $stripeProduct = Product::create($this->getStripeProductDataFromProductVariant($productVariant));
        $productVariant->setStripeProductId($stripeProduct->id);
    }


    /**
     * @throws ApiErrorException
     */
    public function updateSubscriptionProduct(ProductVariantInterface $productVariant): void
    {
        if (!$productVariant->isRecurring()) {
            return;
        }
        if (null === $productVariant->getStripeProductId()) {
            $this->createSubscriptionProduct($productVariant);
        } else {
            try {
                $currentStripeProduct = Product::retrieve($productVariant->getStripeProductId());
                $submittedData = $this->getStripeProductDataFromProductVariant($productVariant);
                if ($submittedData !== $this->getStripeProductDataFromStripeProduct($currentStripeProduct)) {
                    Product::update(
                        $productVariant->getStripeProductId(),
                        $submittedData
                    );
                }
            } catch (ApiErrorException $e) {
                $this->createSubscriptionProduct($productVariant);
            }
        }
    }

    /**
     * @throws ApiErrorException
     */
    public function removeSubscriptionProduct(ProductVariantInterface $productVariant): void
    {
        if (!$productVariant->isRecurring() || null === $productVariant->getStripeProductId()) {
            return;
        }
        Product::update(
            $productVariant->getStripeProductId(),
            ['active' => false]
        );
    }

    public function retrievePriceId(OrderItemInterface $orderItem): ?string
    {
        /** @var ProductVariantInterface $variant */
        $variant = $orderItem->getVariant();
        if (false === $variant->isRecurring()) {
            return null;
        }
        /** @var OrderInterface|null $order */
        $order = $orderItem->getOrder();

        if (null === $order) {
            return null;
        }
        $amount = $orderItem->getTotal();
        $currency = StripeUtility::currencyStripeCompatible($order->getCurrencyCode());

        $interval = StripeUtility::retrieveStepAndAmountFromInterval($orderItem->getVariant()->getInterval())['step'];

        if (null === $interval) {
            return null;
        }

        $productId = $variant->getStripeProductId();

        if (null === $productId) {
            return null;
        }

        if ($price = $this->findExistingPrice($currency, $amount, $interval, $productId)) {
            return $price->id;
        } else {
            $newPrice = Price::create([
                'currency' => $currency,
                'unit_amount' => $amount,
                'recurring' => ['interval' => $interval],
                'product' => $productId
            ]);
            return $newPrice->id;
        }
    }

    private function findExistingPrice(string $currency, int $unitAmount, string $interval, string $productId): ?Price
    {
        try {
            $prices = Price::all(['limit' => 100]);

            foreach ($prices->data as $price) {
                if (
                    $price->currency === $currency &&
                    $price->unit_amount === $unitAmount &&
                    isset($price->recurring) &&
                    $price->recurring->interval === $interval &&
                    $price->product === $productId
                ) {
                    return $price;
                }
            }
            return null;

        } catch (ApiErrorException $e) {
            return null;
        }
    }

    private function getStripeProductDataFromProductVariant(ProductVariantInterface $productVariant): array
    {
        return [
            'name' => $productVariant->getName(),
            'description' => $productVariant->getDescriptor(),
        ];
    }

    private function getStripeProductDataFromStripeProduct(Product $stripeProduct): array
    {
        return [
            'name' => $stripeProduct->name,
            'description' => $stripeProduct->description,
        ];
    }
}
