<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Guard;

use VK\SyliusStripePaymentPlugin\Entity\SubscriptionInterface;

final class SubscriptionGuard implements SubscriptionGuardInterface
{
    public function isEligibleForPaymentsAbort(SubscriptionInterface $subscription): bool
    {
        return 2 < $subscription->getRecentFailedPaymentsCount();
    }

    public function isCompletable(SubscriptionInterface $subscription): bool
    {
       /* foreach ($subscription->getSchedules() as $schedule) {
            /** @var MollieSubscriptionScheduleInterface $schedule */
        /*    if (false === $schedule->isFulfilled()) {
                return false;
            }
        }*/

        return true;
    }
}
