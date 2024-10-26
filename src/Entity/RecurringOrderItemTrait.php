<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderItemInterface;

trait RecurringOrderItemTrait
{
    #[ORM\Column(type: "string", nullable: true)]
    private ?string $stripePriceId = null;

    public function getStripePriceId(): ?string
    {
        return $this->stripePriceId;
    }

    public function setStripePriceId(?string $stripePriceId): void
    {
        $this->stripePriceId = $stripePriceId;
    }

}
