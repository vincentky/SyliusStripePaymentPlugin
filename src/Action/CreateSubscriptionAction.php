<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Action;

use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Convert;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use VK\SyliusStripePaymentPlugin\Provider\DetailsProviderInterface;
use VK\SyliusStripePaymentPlugin\Service\StripeServiceInterface;

final class ConvertPaymentAction implements ConvertPaymentActionInterface
{
    public function __construct(private readonly DetailsProviderInterface $detailsProvider, private readonly StripeServiceInterface $stripeService)
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

        if ($order->hasRecurringContents()){
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
