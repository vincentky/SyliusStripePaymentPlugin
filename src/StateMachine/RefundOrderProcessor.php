<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\StateMachine;

use VK\SyliusStripePaymentPlugin\Command\RefundPayment;
use SM\Event\TransitionEvent;
use Sylius\Component\Core\Model\PaymentInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class RefundOrderProcessor
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    public function __invoke(PaymentInterface $payment, TransitionEvent $event): void
    {
        if (PaymentInterface::STATE_COMPLETED !== $event->getState()) {
            return;
        }

        /** @var int|null $paymentId */
        $paymentId = $payment->getId();
        Assert::notNull($paymentId);
        $this->commandBus->dispatch(new RefundPayment($paymentId));
    }
}
