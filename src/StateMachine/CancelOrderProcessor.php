<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\StateMachine;

use VK\SyliusStripePaymentPlugin\Command\CancelPayment;
use SM\Event\TransitionEvent;
use Sylius\Component\Core\Model\PaymentInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Webmozart\Assert\Assert;

final class CancelOrderProcessor
{
    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(
        MessageBusInterface $commandBus
    ) {
        $this->commandBus = $commandBus;
    }

    public function __invoke(PaymentInterface $payment, TransitionEvent $event): void
    {
        if (false === in_array($event->getState(), [
                PaymentInterface::STATE_NEW,
                PaymentInterface::STATE_AUTHORIZED,
            ], true)) {
            return;
        }

        /** @var int|null $paymentId */
        $paymentId = $payment->getId();
        Assert::notNull($paymentId);
        $this->commandBus->dispatch(new CancelPayment($paymentId));
    }
}
