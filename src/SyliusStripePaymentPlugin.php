<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin;

use VK\SyliusStripePaymentPlugin\DependencyInjection\Compiler\PayumGatewayConfigOverride;
use VK\SyliusStripePaymentPlugin\DependencyInjection\Compiler\PayumStoragePaymentAliaser;
use VK\SyliusStripePaymentPlugin\DependencyInjection\Compiler\WinzouStateMachineCallbacksModifier;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SyliusStripePaymentPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new PayumGatewayConfigOverride([
            'stripe_checkout_session' => [
                'payum.template.layout' => '@SyliusPayum/layout.html.twig',
            ],
            'stripe_js' => [
                'payum.template.layout' => '@SyliusPayum/layout.html.twig',
            ],
        ]));

        $container->addCompilerPass(new WinzouStateMachineCallbacksModifier());
        $container->addCompilerPass(new PayumStoragePaymentAliaser());

        parent::build($container);
    }
}
