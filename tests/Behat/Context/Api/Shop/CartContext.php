<?php

declare(strict_types=1);

namespace Tests\VK\SyliusStripePaymentPlugin\Behat\Context\Api\Shop;

use Behat\Behat\Context\Context;
use LogicException;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\Behat\Context\Api\Resources;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\VK\SyliusStripePaymentPlugin\Behat\Mocker\StripeCheckoutSessionMocker;
use Tests\VK\SyliusStripePaymentPlugin\Behat\Mocker\StripeJsMocker;
use Webmozart\Assert\Assert;

final class CartContext implements Context
{
    private ApiClientInterface $shopClient;

    private ResponseCheckerInterface $responseChecker;

    private SharedStorageInterface $sharedStorage;

    private StripeCheckoutSessionMocker $stripeCheckoutSessionMocker;

    private StripeJsMocker $stripeJsMocker;

    public function __construct(
        ApiClientInterface $shopClient,
        ResponseCheckerInterface $responseChecker,
        SharedStorageInterface $sharedStorage,
        StripeCheckoutSessionMocker $stripeCheckoutSessionMocker,
        StripeJsMocker $stripeJsMocker
    ) {
        $this->shopClient = $shopClient;
        $this->responseChecker = $responseChecker;
        $this->sharedStorage = $sharedStorage;
        $this->stripeCheckoutSessionMocker = $stripeCheckoutSessionMocker;
        $this->stripeJsMocker = $stripeJsMocker;
    }

    /**
     * @When /^I see the payment configuration for Stripe Checkout Session$/
     */
    public function iSeeThePaymentConfigurationForStripeCheckoutSession(): void
    {
        $this->stripeCheckoutSessionMocker->mockCaptureOrAuthorize(function () {
            $this->showPaymentConfiguration();
        });
    }

    /**
     * @When /^I see the payment configuration for Stripe JS$/
     */
    public function iSeeThePaymentConfigurationForStripeJs(): void
    {
        $this->stripeJsMocker->mockCaptureOrAuthorize(function () {
            $this->showPaymentConfiguration();
        });
    }

    /**
     * @Then /^I should be able to get "([^"]+)" with value "([^"]+)"$/
     */
    public function iShouldBeAbleToGetWithValue(string $key, string $expectedValue): void
    {
        $response = $this->sharedStorage->get('response');
        $value = $this->responseChecker->getValue($response, $key);
        Assert::eq($value, $expectedValue);
    }

    /**
     * @Then /^I should be able to get "([^"]+)" with a boolean value (1|0)$/
     */
    public function iShouldBeAbleToGetWithABooleanValue(string $key, bool $expectedValue): void
    {
        $response = $this->sharedStorage->get('response');
        $value = $this->responseChecker->getValue($response, $key);
        Assert::eq($value, $expectedValue);
    }

    public function showPaymentConfiguration(): void
    {
        $tokenValue = $this->getCartTokenValue();

        $this->shopClient->show(
            Resources::ORDERS,
            sprintf(
                '%s/%s/%s/configuration',
                $tokenValue,
                Resources::PAYMENTS,
                $this->getCart()['payments'][0]['id']
            )
        );

        $this->sharedStorage->set('response', $this->shopClient->getLastResponse());
    }

    private function getCart(): array
    {
        return $this->responseChecker->getResponseContent($this->shopClient->show(Resources::ORDERS, $this->getCartTokenValue()));
    }

    private function getCartTokenValue(): string
    {
        if ($this->sharedStorage->has('cart_token')) {
            return $this->sharedStorage->get('cart_token');
        }

        throw new LogicException('Unable to found the cart_token inside the shared storage.');
    }
}
