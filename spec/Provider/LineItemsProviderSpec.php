<?php

declare(strict_types=1);

namespace spec\VK\SyliusStripePaymentPlugin\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use VK\SyliusStripePaymentPlugin\Provider\LineItemProviderInterface;
use VK\SyliusStripePaymentPlugin\Provider\LineItemsProvider;
use VK\SyliusStripePaymentPlugin\Provider\LineItemsProviderInterface;
use VK\SyliusStripePaymentPlugin\Provider\ShippingLineItemProviderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

final class LineItemsProviderSpec extends ObjectBehavior
{
    public function let(
        LineItemProviderInterface $lineItemProvider,
        ShippingLineItemProviderInterface $shippingLineItemProvider
    ): void {
        $this->beConstructedWith(
            $lineItemProvider,
            $shippingLineItemProvider
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(LineItemsProvider::class);
        $this->shouldHaveType(LineItemsProviderInterface::class);
    }

    public function it_get_line_items(
        OrderInterface $order,
        OrderItemInterface $orderItem,
        LineItemProviderInterface $lineItemProvider,
        ShippingLineItemProviderInterface $shippingLineItemProvider
    ): void {
        $lineItem = [];
        $orderItems = new ArrayCollection([
            $orderItem->getWrappedObject(),
        ]);
        $order->getItems()->willReturn($orderItems);
        $lineItemProvider->getLineItem($orderItem)->willReturn($lineItem);
        $shippingLineItemProvider->getLineItem($order)->willReturn(null);

        $this->getLineItems($order)->shouldReturn([
            $lineItem,
        ]);
    }

    public function it_get_empty_line_items(
        OrderInterface $order,
        ShippingLineItemProviderInterface $shippingLineItemProvider
    ): void {
        $orderItems = new ArrayCollection([]);
        $order->getItems()->willReturn($orderItems);
        $shippingLineItemProvider->getLineItem($order)->willReturn(null);

        $this->getLineItems($order)->shouldReturn([]);
    }
}
