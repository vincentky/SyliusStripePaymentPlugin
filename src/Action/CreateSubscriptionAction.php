<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Action;

use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Convert;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Order\Repository\OrderRepositoryInterface;
use VK\SyliusStripePaymentPlugin\Factory\SubscriptionFactoryInterface;
use VK\SyliusStripePaymentPlugin\Repository\SubscriptionRepositoryInterface;

final class CreateSubscriptionAction implements CreateSubscriptionActionInterface
{
    public function __construct(private readonly SubscriptionRepositoryInterface $subscriptionRepository,
                                private readonly SubscriptionFactoryInterface $subscriptionFactory,
                                private readonly OrderRepositoryInterface $orderRepository)
    {

    }

    /** @param Convert $request */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();
        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        if ($order->hasRecurringContents()) {
            foreach ($order->getRecurringItems() as $item) {
                $item->setStripePriceId($this->stripeService->retrievePriceId($item));
            }
        }

        $details = $this->detailsProvider->getDetails($order);

        $request->setResult($details);
    }

    public function supports($request): bool
    {
        return
            $request instanceof Convert &&
            $request->getSource() instanceof PaymentInterface &&
            $request->getTo() === 'array';
    }
}
