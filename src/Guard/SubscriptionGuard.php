<?php


declare(strict_types=1);

namespace SyliusMolliePlugin\Guard;

use SyliusMolliePlugin\Entity\MollieSubscriptionInterface;
use SyliusMolliePlugin\Entity\MollieSubscriptionScheduleInterface;

final class SubscriptionGuard implements SubscriptionGuardInterface
{
    public function isEligibleForPaymentsAbort(MollieSubscriptionInterface $subscription): bool
    {
        return 2 < $subscription->getRecentFailedPaymentsCount();
    }

    public function isCompletable(MollieSubscriptionInterface $subscription): bool
    {
        foreach ($subscription->getSchedules() as $schedule) {
            /** @var MollieSubscriptionScheduleInterface $schedule */
            if (false === $schedule->isFulfilled()) {
                return false;
            }
        }

        return true;
    }
}
