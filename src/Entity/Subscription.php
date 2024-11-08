<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\PaymentInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_subscription')]
class Subscription implements SubscriptionInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    #[ORM\Column(type: 'string', nullable: false)]
    protected string $state = SubscriptionInterface::STATE_NEW;

    #[ORM\ManyToOne(targetEntity: CustomerInterface::class)]
    #[ORM\JoinColumn(referencedColumnName: 'id')]
    protected ?CustomerInterface $customer = null;

    #[ORM\Column(type: 'string', nullable: true)]
    protected string $hostname = '';

    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $recurringInterval = '';

    #[ORM\Column(type: 'integer', nullable: true)]
    protected ?int $NumberOfRepetitions;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected \DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTime $startedAt = null;

    #[ORM\ManyToOne(targetEntity: OrderItemInterface::class)]
    protected OrderItemInterface $orderItem;

    #[ORM\Column(type: 'string', nullable: false, options: ['default' => 'none'])]
    protected string $processingState = SubscriptionInterface::PROCESSING_STATE_NONE;

    #[ORM\Column(type: 'string', nullable: false, options: ['default' => 'pending'])]
    protected string $paymentState = SubscriptionInterface::PAYMENT_STATE_PENDING;

    #[ORM\Column(type: 'integer', nullable: false, options: ['default' => 0])]
    protected int $recentFailedPaymentsCount = 0;

    #[ORM\ManyToMany(targetEntity: PaymentInterface::class)]
    #[ORM\JoinTable(name: 'sylius_subscription_payments')]
    #[ORM\JoinColumn(name: 'subscription_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'payment_id', referencedColumnName: 'id')]
    protected Collection $payments;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
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

    public function getOrderItem(): OrderItemInterface
    {
        return $this->orderItem;
    }

    public function setOrderItem(OrderItemInterface $orderItem): void
    {
        $this->orderItem = $orderItem;
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

    public function getLastPayment(): ?PaymentInterface
    {
        if ($this->payments->isEmpty()) {
            return null;
        }

        return $this->payments->last();
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    public function getRecurringInterval(): ?string
    {
        return $this->recurringInterval;
    }

    public function setRecurringInterval(?string $recurringInterval): void
    {
        $this->recurringInterval = $recurringInterval;
    }

    public function getNumberOfRepetitions(): ?int
    {
        return $this->NumberOfRepetitions;
    }

    public function setNumberOfRepetitions(?int $NumberOfRepetitions): void
    {
        $this->NumberOfRepetitions = $NumberOfRepetitions;
    }
}
