<?php


declare(strict_types=1);

namespace SyliusMolliePlugin\Entity;

interface MollieSubscriptionConfigurationInterface
{
    public const SUPPORTED_INTERVAL_STEPS = [
        'days',
        'weeks',
        'months',
    ];

    public function getId(): ?int;

    public function getHostName(): string;

    public function getPort(): ?int;

    public function getSubscriptionId(): ?string;

    public function getMandateId(): ?string;

    public function getCustomerId(): ?string;

    public function getInterval(): ?string;

    public function setHostName(string $hostName): void;

    public function setPort(?int $port): void;

    public function setSubscriptionId(?string $subscriptionId): void;

    public function setMandateId(?string $mandateId): void;

    public function setCustomerId(?string $customerId): void;

    public function setInterval(string $interval): void;

    public function setNumberOfRepetitions(int $numberOfRepetitions): void;

    public function getNumberOfRepetitions(): int;

    public function setPaymentDetailsConfiguration(array $paymentDetailsConfiguration): void;

    public function getPaymentDetailsConfiguration(): array;

    public function getSubscription(): MollieSubscriptionInterface;
}
