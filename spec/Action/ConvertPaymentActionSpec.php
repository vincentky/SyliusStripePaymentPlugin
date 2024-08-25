<?php

declare(strict_types=1);

namespace spec\VK\SyliusStripePaymentPlugin\Action;

use VK\SyliusStripePaymentPlugin\Action\ConvertPaymentAction;
use VK\SyliusStripePaymentPlugin\Action\ConvertPaymentActionInterface;
use VK\SyliusStripePaymentPlugin\Provider\DetailsProviderInterface;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\Convert;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Collaborator;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;

final class ConvertPaymentActionSpec extends ObjectBehavior
{
    /**
     * @param Collaborator|DetailsProviderInterface $detailsProvider
     */
    public function let(DetailsProviderInterface $detailsProvider): void
    {
        $this->beConstructedWith($detailsProvider);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ConvertPaymentAction::class);
    }

    public function it_implements_action_interface(): void
    {
        $this->shouldHaveType(ActionInterface::class);
        $this->shouldHaveType(ConvertPaymentActionInterface::class);
    }

    /**
     * @param Convert|Collaborator $request
     * @param Collaborator|PaymentInterface $payment
     * @param Collaborator|OrderInterface $order
     * @param Collaborator|DetailsProviderInterface $detailsProvider
     */
    public function it_executes(
        Convert $request,
        PaymentInterface $payment,
        OrderInterface $order,
        DetailsProviderInterface $detailsProvider
    ): void {
        $details = [];
        $payment->getOrder()->willReturn($order);
        $request->getSource()->willReturn($payment);
        $request->getTo()->willReturn('array');
        $detailsProvider->getDetails($order)->willReturn($details);

        $request->setResult($details)->shouldBeCalled();

        $this->execute($request);
    }

    /**
     * @param Convert|Collaborator $request
     * @param Collaborator|PaymentInterface $payment
     */
    public function it_supports_only_convert_request_payment_source_and_array_to(
        Convert $request,
        PaymentInterface $payment
    ): void {
        $request->getSource()->willReturn($payment);
        $request->getTo()->willReturn('array');

        $this->supports($request)->shouldReturn(true);
    }
}
