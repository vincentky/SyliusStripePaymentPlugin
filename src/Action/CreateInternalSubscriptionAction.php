<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Action;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Convert;
use Stripe\Checkout\Session;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Repository\PaymentRepositoryInterface;
use VK\PayumStripe\Request\Api\Resource\CreateSubscription;
use VK\SyliusStripePaymentPlugin\Entity\OrderInterface;
use VK\SyliusStripePaymentPlugin\Factory\SubscriptionFactoryInterface;
use VK\SyliusStripePaymentPlugin\Repository\SubscriptionRepositoryInterface;

final class CreateInternalSubscriptionAction implements CreateInternalSubscriptionActionInterface
{
    public function __construct(private readonly SubscriptionRepositoryInterface $subscriptionRepository,
                                private readonly SubscriptionFactoryInterface $subscriptionFactory,
                                private readonly PaymentRepositoryInterface $paymentRepository,)
    {

    }

    /** @param Convert $request */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $mode = Session::MODE_PAYMENT;
        if ($model->offsetExists('mode')) {
            $mode = $model->offsetGet('mode');
        }
        if (Session::MODE_PAYMENT === $mode) {
            return;
        }

        /** @var PaymentInterface $payment */
        $payment = $this->paymentRepository->findOneBy(['id' => $model['metadata']['payment_id']]);

        if (null === $payment) {
            throw new \RuntimeException('Payment not found');
        }
        /** @var OrderInterface $rootOrder */
        $rootOrder =$payment->getOrder();

        foreach ($payment->getOrder()->getRecurringItems() as $item) {
            $subscription = $this->subscriptionFactory->createFromFirstOrderWithOrderItemAndPaymentConfiguration(
                $rootOrder,
                $item,
                $model->getArrayCopy()
            );
            $this->subscriptionRepository->add($subscription);
        }
    }

    public function supports($request): bool
    {
        return
            $request instanceof CreateSubscription &&
            $request->getModel() instanceof \ArrayAccess;
    }
}
