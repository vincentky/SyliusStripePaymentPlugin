<?php

declare(strict_types=1);

namespace Tests\VK\SyliusStripePaymentPlugin\Behat\Mocker\Api;

use ArrayObject;
use VK\PayumStripe\Action\Api\Resource\AbstractCreateAction;
use VK\PayumStripe\Request\Api\Resource\CreateRefund;
use Stripe\Checkout\Session;
use Stripe\Refund;
use Sylius\Behat\Service\Mocker\MockerInterface;

final class RefundMocker
{
    /** @var MockerInterface */
    private $mocker;

    public function __construct(MockerInterface $mocker)
    {
        $this->mocker = $mocker;
    }

    public function mockCreateAction(): void
    {
        $mockCreateSession = $this->mocker->mockService(
            'tests.sylius_stripe_payment_plugin.behat.mocker.action.create_refund',
            AbstractCreateAction::class
        );

        $mockCreateSession
            ->shouldReceive('setApi')
            ->once();
        $mockCreateSession
            ->shouldReceive('setGateway')
            ->once();

        $mockCreateSession
            ->shouldReceive('supports')
            ->andReturnUsing(function ($request) {
                return $request instanceof CreateRefund;
            });

        $mockCreateSession
            ->shouldReceive('execute')
            ->once()
            ->andReturnUsing(function (CreateRefund $request) {
                /** @var ArrayObject $rModel */
                $rModel = $request->getModel();
                $refund = Session::constructFrom(array_merge([
                    'id' => 're_1',
                    'object' => Refund::OBJECT_NAME,
                ], $rModel->getArrayCopy()));
                $request->setApiResource($refund);
            });
    }
}
