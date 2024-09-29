<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "sylius_subscription_configuration")]
class SubscriptionConfiguration implements SubscriptionConfigurationInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    protected ?int $id = null;

    #[ORM\Column(type: "string", nullable: false)]
    protected string $hostName = '';

    #[ORM\Column(type: "integer", nullable: true)]
    protected ?int $port = null;

    #[ORM\Column(type: "string", nullable: true)]
    protected ?string $subscriptionId = null;

    #[ORM\Column(type: "string", nullable: true)]
    protected ?string $mandateId = null;

    #[ORM\Column(name: "stripe_customer_id", type: "string", nullable: true)]
    protected ?string $customerId = null;

    #[ORM\Column(type: "integer", nullable: false)]
    protected int $numberOfRepetitions = 1;

    #[ORM\Column(type: "json", nullable: false)]
    protected array $paymentDetailsConfiguration = [];

    #[ORM\Column(name: "`interval`", type: "string", nullable: false)]
    protected ?string $interval = null;

    #[ORM\OneToOne(mappedBy: "subscriptionConfiguration", targetEntity: Subscription::class)]
    protected SubscriptionInterface $subscription;

    public function __construct(SubscriptionInterface $subscription)
    {
        $this->subscription = $subscription;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHostName(): string
    {
        return $this->hostName;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getSubscriptionId(): ?string
    {
        return $this->subscriptionId;
    }

    public function getMandateId(): ?string
    {
        return $this->mandateId;
    }

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function getInterval(): ?string
    {
        return $this->interval;
    }

    public function getNumberOfRepetitions(): int
    {
        return $this->numberOfRepetitions;
    }

    public function getPaymentDetailsConfiguration(): array
    {
        return $this->paymentDetailsConfiguration;
    }

    public function getSubscription(): SubscriptionInterface
    {
        return $this->subscription;
    }

    public function setHostName(string $hostName): void
    {
        $this->hostName = $hostName;
    }

    public function setPort(?int $port): void
    {
        $this->port = $port;
    }

    public function setSubscriptionId(?string $subscriptionId): void
    {
        $this->subscriptionId = $subscriptionId;
    }

    public function setMandateId(?string $mandateId): void
    {
        $this->mandateId = $mandateId;
    }

    public function setCustomerId(?string $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function setInterval(?string $interval): void
    {
        $this->interval = $interval;
    }

    public function setNumberOfRepetitions(int $numberOfRepetitions): void
    {
        $this->numberOfRepetitions = $numberOfRepetitions;
    }

    public function setPaymentDetailsConfiguration(array $paymentDetailsConfiguration): void
    {
        $this->paymentDetailsConfiguration = $paymentDetailsConfiguration;
    }
}
