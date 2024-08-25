<?php

declare(strict_types=1);

namespace spec\VK\SyliusStripePaymentPlugin\Provider;

use VK\SyliusStripePaymentPlugin\Provider\PaymentMethodTypesProvider;
use VK\SyliusStripePaymentPlugin\Provider\PaymentMethodTypesProviderInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;

final class PaymentMethodTypesProviderSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith([
            'card',
        ]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PaymentMethodTypesProvider::class);
        $this->shouldHaveType(PaymentMethodTypesProviderInterface::class);
    }

    public function it_get_payment_method_types(
        OrderInterface $order
    ): void {
        $this->getPaymentMethodTypes($order)->shouldReturn([
            'card',
        ]);
    }
}
