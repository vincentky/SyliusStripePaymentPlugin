<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use VK\SyliusStripePaymentPlugin\Entity\ProductVariantInterface;
use VK\SyliusStripePaymentPlugin\Service\StripeServiceInterface;

final readonly class DoctrineSubscriber implements EventSubscriber
{
    public function __construct(private StripeServiceInterface $stripeService, private EntityManagerInterface $entityManager)
    {

    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        switch (true) {
            case $entity instanceof ProductVariantInterface:
                $this->stripeService->createSubscriptionProduct($entity);
                $this->entityManager->persist($entity);
                break;
        }
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        switch (true) {
            case $entity instanceof ProductVariantInterface:
                $this->stripeService->updateSubscriptionProduct($entity);
                $this->entityManager->persist($entity);
                break;
        }
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        switch (true) {
            case $entity instanceof ProductVariantInterface:
                $this->stripeService->removeSubscriptionProduct($entity);
                break;
        }
    }
}
