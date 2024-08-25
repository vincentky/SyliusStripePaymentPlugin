<?php

declare(strict_types=1);

namespace spec\VK\SyliusStripePaymentPlugin\Provider;

use VK\SyliusStripePaymentPlugin\Provider\ModeProvider;
use VK\SyliusStripePaymentPlugin\Provider\ModeProviderInterface;
use PhpSpec\ObjectBehavior;
use Stripe\Checkout\Session;
use Sylius\Component\Core\Model\OrderInterface;

final class ModeProviderSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ModeProvider::class);
        $this->shouldHaveType(ModeProviderInterface::class);
    }

    public function it_get_payment_method_types(
        OrderInterface $order
    ): void {
        $this->getMode($order)->shouldReturn(Session::MODE_PAYMENT);
    }
}
