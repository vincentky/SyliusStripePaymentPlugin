<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Transition;

final class RecurringTransitions
{
    public const GRAPH_MANUAL = 'subscription_payment_graph_manual';

    public const TRANSITION_ACTIVATE = 'activate';

    public const TRANSITION_CANCEL = 'cancel';

    public const TRANSITION_COMPLETE = 'complete';

    private function __construct()
    {
    }
}
