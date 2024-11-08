<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Factory;

use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use VK\SyliusStripePaymentPlugin\Entity\OrderInterface;
use VK\SyliusStripePaymentPlugin\Entity\ProductVariantInterface;
use VK\SyliusStripePaymentPlugin\Entity\SubscriptionInterface;
use Webmozart\Assert\Assert;

final class SubscriptionFactory implements SubscriptionFactoryInterface
{
    // private FactoryInterface $decoratedFactory;

    public function __construct(
        private readonly FactoryInterface $decoratedFactory,
        private readonly RouterInterface $router
    )
    {
    }

    public function createNew(): SubscriptionInterface
    {
        /** @var SubscriptionInterface $subscriptionTemplate */
        $subscriptionTemplate = $this->decoratedFactory->createNew();

        return $subscriptionTemplate;
    }

    public function createFromFirstOrder(OrderInterface $order): SubscriptionInterface
    {
        $subscriptionTemplate = $this->createNew();

        Assert::notNull($order->getCustomer());
        $subscriptionTemplate->setCustomer($order->getCustomer());

        /** @var PaymentInterface $payment */
        foreach ($order->getPayments() as $payment) {
            $subscriptionTemplate->addPayment($payment);
        }

        return $subscriptionTemplate;
    }

    public function createFromFirstOrderWithOrderItemAndPaymentConfiguration(
        OrderInterface     $order,
        OrderItemInterface $orderItem,
        array              $paymentConfiguration = [],
        string             $mandateId = null
    ): SubscriptionInterface
    {
        $variant = $orderItem->getVariant();
        if (!$variant) {
            throw new \InvalidArgumentException(
                sprintf('Variant should be instance of "%s::class".', ProductVariantInterface::class)
            );
        }
        $routerContext = $this->router->getContext();
        $hostname = $routerContext->getHost();

        $subscriptionTemplate = $this->createFromFirstOrder($order);
        $subscriptionTemplate->setHostName($hostname);
        Assert::notNull($variant->getInterval());
        $subscriptionTemplate->setRecurringInterval($variant->getInterval());
        $subscriptionTemplate->setNumberOfRepetitions($variant->getTimes());
        $subscriptionTemplate->setOrderItem($orderItem);

        return $subscriptionTemplate;
    }
}
