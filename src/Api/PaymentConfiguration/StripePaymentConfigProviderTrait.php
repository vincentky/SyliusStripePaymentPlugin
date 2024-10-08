<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Api\PaymentConfiguration;

use Sylius\Bundle\PayumBundle\Model\GatewayConfigInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Webmozart\Assert\Assert;

trait StripePaymentConfigProviderTrait
{
    private string $factoryName;

    public function __construct(string $factoryName)
    {
        $this->factoryName = $factoryName;
    }

    public function supports(PaymentMethodInterface $paymentMethod): bool
    {
        /** @var GatewayConfigInterface|null $gatewayConfig */
        $gatewayConfig = $paymentMethod->getGatewayConfig();
        Assert::notNull($gatewayConfig);

        $config = $gatewayConfig->getConfig();
        /** @var string $factory */
        $factory = $config['factory'] ?? $gatewayConfig->getFactoryName();

        return $factory === $this->factoryName;
    }

    public function provideDefaultConfiguration(PaymentInterface $payment): array
    {
        $gatewayConfig = $this->getGatewayConfig($payment);

        $config = $gatewayConfig->getConfig();

        return [
            'publishable_key' => $config['publishable_key'],
            'use_authorize' => $config['use_authorize'] ?? false,
        ];
    }

    private function getGatewayConfig(PaymentInterface $payment): GatewayConfigInterface
    {
        /** @var PaymentMethodInterface|null $paymentMethod */
        $paymentMethod = $payment->getMethod();
        Assert::notNull($paymentMethod, 'Unable to found a PaymentMethod on this Payment.');

        /** @var GatewayConfigInterface|null $gatewayConfig */
        $gatewayConfig = $paymentMethod->getGatewayConfig();
        Assert::notNull($gatewayConfig, 'Unable to found a GatewayConfig on this PaymentMethod.');

        return $gatewayConfig;
    }
}
