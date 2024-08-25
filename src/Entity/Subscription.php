<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\OrderInterface as SyliusOrder;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

class Subscription implements SubscriptionInterface
{
    protected ?int $id = null;

    protected string $state = SubscriptionInterface::STATE_NEW;

    protected ?CustomerInterface $customer = null;

    protected \DateTime $createdAt;

    protected ?\DateTime $startedAt = null;

    protected OrderItemInterface $orderItem;

    protected Collection $schedules;

    protected string $processingState = SubscriptionInterface::PROCESSING_STATE_NONE;

    protected string $paymentState = SubscriptionInterface::PAYMENT_STATE_PENDING;

    protected int $recentFailedPaymentsCount = 0;

    /** @var Collection<int, PaymentInterface> */
    protected Collection $payments;

    /** @var Collection<int, SyliusOrder> */
    protected Collection $orders;

    protected SubscriptionConfigurationInterface $subscriptionConfiguration;

    public function __construct()
    {
        $this->subscriptionConfiguration = new SubscriptionConfiguration($this);
        $this->payments = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(PaymentInterface $payment): void
    {
        if (false === $this->payments->contains($payment)) {
            $this->payments->add($payment);
        }
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(SyliusOrder $order): void
    {
        if (false === $this->orders->contains($order)) {
            $this->orders->add($order);
        }
    }

    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    public function setCustomer(CustomerInterface $customer): void
    {
        $this->customer = $customer;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getStartedAt(): ?\DateTime
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTime $startedAt = null): void
    {
        $this->startedAt = $startedAt;
    }

    public function getLastOrder(): ?SyliusOrder
    {
        if ($this->orders->isEmpty()) {
            return null;
        }

        return $this->orders->last();
    }

    public function getOrderItem(): OrderItemInterface
    {
        return $this->orderItem;
    }

    public function setOrderItem(OrderItemInterface $orderItem): void
    {
        $this->orderItem = $orderItem;
    }

    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function getFirstOrder(): ?OrderInterface
    {
        /** @var OrderInterface $order */
        $order = $this->orderItem->getOrder();

        return $order;
    }

    public function getProcessingState(): string
    {
        return $this->processingState;
    }

    public function setProcessingState(string $processingState): void
    {
        $this->processingState = $processingState;
    }

    public function getRecentFailedPaymentsCount(): int
    {
        return $this->recentFailedPaymentsCount;
    }

    public function incrementFailedPaymentCounter(): void
    {
        ++$this->recentFailedPaymentsCount;
    }

    public function resetFailedPaymentCount(): void
    {
        $this->recentFailedPaymentsCount = 0;
    }

    public function getPaymentState(): string
    {
        return $this->paymentState;
    }

    public function setPaymentState(string $paymentState): void
    {
        $this->paymentState = $paymentState;
    }

    public function getSubscriptionConfiguration(): SubscriptionConfigurationInterface
    {
        return $this->subscriptionConfiguration;
    }

    public function getLastPayment(): ?PaymentInterface
    {
        if ($this->payments->isEmpty()) {
            return null;
        }

        return $this->payments->last();
    }
}
