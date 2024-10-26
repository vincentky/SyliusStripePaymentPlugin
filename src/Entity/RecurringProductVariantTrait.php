<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

trait RecurringProductVariantTrait
{
    #[ORM\Column(name: "recurring", type: "boolean", nullable: false, options: ["default" => 0])]
    private bool $recurring = false;

    #[ORM\Column(name: "recurring_times", type: "integer", nullable: true)]
    private ?int $times = null;

    #[ORM\Column(name: "recurring_interval", type: "string", nullable: true)]
    private ?string $interval = null;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $stripeProductId = null;


    public function isRecurring(): bool
    {
        return $this->recurring;
    }

    public function setRecurring(bool $recurring): void
    {
        $this->recurring = $recurring;
    }

    public function getTimes(): ?int
    {
        return $this->times;
    }

    public function setTimes(?int $times): void
    {
        $this->times = $times;
    }

    public function getInterval(): ?string
    {
        return $this->interval;
    }

    public function setInterval(?string $interval): void
    {
        $this->interval = $interval;
    }


    public function getStripeProductId(): ?string
    {
        return $this->stripeProductId;
    }

    public function setStripeProductId(string $stripeProductId): void
    {
        $this->stripeProductId = $stripeProductId;
    }
}

