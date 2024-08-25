<?php

declare(strict_types=1);

namespace Tests\VK\SyliusStripePaymentPlugin\Behat\Page\Shop;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface PayumNotifyPageInterface extends SymfonyPageInterface
{
    public function getNotifyUrl(array $urlParameters): string;
}
