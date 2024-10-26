<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Provider;

use Sylius\Component\Core\Model\OrderItemInterface;
use VK\SyliusStripePaymentPlugin\Entity\OrderInterface;
use VK\SyliusStripePaymentPlugin\Utility\StripeUtility;

final class LineItemProvider implements LineItemProviderInterface
{
    /** @var LineItemImagesProviderInterface */
    private $lineItemImagesProvider;

    /** @var LinetItemNameProviderInterface */
    private $lineItemNameProvider;

    public function __construct(
        LineItemImagesProviderInterface $lineItemImagesProvider,
        LinetItemNameProviderInterface  $lineItemNameProvider
    )
    {
        $this->lineItemImagesProvider = $lineItemImagesProvider;
        $this->lineItemNameProvider = $lineItemNameProvider;
    }


    public function getLineItem(OrderItemInterface $orderItem): ?array
    {
        /** @var OrderInterface|null $order */
        $order = $orderItem->getOrder();

        if (null === $order) {
            return null;
        }

        if (null !== $orderItem->getStripePriceId()) {
            return [
                'price' => $orderItem->getStripePriceId(),
                'quantity' => 1,
            ];
        }

        $priceData = [
            'unit_amount' => $orderItem->getTotal(),
            'currency' => $order->getCurrencyCode(),
            'product_data' => [
                'name' => $this->lineItemNameProvider->getItemName($orderItem),
                'images' => $this->lineItemImagesProvider->getImageUrls($orderItem),
            ],
        ];

        if ($orderItem->getVariant()?->isRecurring()) {
            $interval = StripeUtility::retrieveStepAndAmountFromInterval($orderItem->getVariant()->getInterval());
            $priceData['recurring'] = [
                'interval' => $interval['step'],
            ];
        }

        return [
            'price_data' => $priceData,
            'quantity' => 1,
        ];
    }
}
