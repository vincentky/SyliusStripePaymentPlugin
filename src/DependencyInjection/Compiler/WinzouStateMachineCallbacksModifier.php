<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class WinzouStateMachineCallbacksModifier implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $refundDisabled = $container->getParameter('sylius_payum_stripe.refund.disabled');

        $container->prependExtensionConfig('winzou_state_machine', [
            'sylius_payment' => [
                'callbacks' => [
                    'before' => [
                        'sylius_payum_stripe_refund' => [
                            'disabled' => $refundDisabled,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
