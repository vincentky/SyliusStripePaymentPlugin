<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\PaymentInterface;
use VK\SyliusStripePaymentPlugin\Entity\SubscriptionInterface;

final class SubscriptionRepository extends EntityRepository implements SubscriptionRepositoryInterface
{
    public function findOneByOrderId(int $orderId): ?SubscriptionInterface
    {
        $qb = $this->createQueryBuilder('q');

        $qb->leftJoin('q.orders', 'o');
        $qb->andWhere('o.id = :orderId');
        $qb->setParameter('orderId', $orderId);

        return $qb->getQuery()->getOneOrNullResult()
        ;
    }

    public function findByOrderId(int $orderId): array
    {
        $qb = $this->createQueryBuilder('q');

        $qb->leftJoin('q.orders', 'o');
        $qb->andWhere('o.id = :orderId');
        $qb->setParameter('orderId', $orderId);

        return $qb->getQuery()->getResult()
        ;
    }

    public function findByPayment(PaymentInterface $payment): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->andWhere(':payment MEMBER OF q.payments');
        $qb->setParameter('payment', $payment);

        return $qb->getQuery()->getResult();
    }

    public function findScheduledSubscriptions(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->andWhere('q.state = :state');
        $qb->setParameter('state', SubscriptionInterface::STATE_ACTIVE);
        $qb->leftJoin('q.schedules', 's');
        $qb->andWhere('s.scheduledDate < :date');
        $qb->setParameter('date', new \DateTime());
        $qb->andWhere('s.fulfilledDate IS NULL');

        return $qb->getQuery()->getResult();
    }

    public function findProcessableSubscriptions(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->andWhere('q.state = :state');
        $qb->setParameter('state', SubscriptionInterface::STATE_PROCESSING);
        $qb->andWhere('q.processingState = :processingState');
        $qb->setParameter('processingState', SubscriptionInterface::PROCESSING_STATE_PENDING);

        return $qb->getQuery()->getResult();
    }

    public function findOneByOrderIdAsString(string $orderId): ?SubscriptionInterface
    {
        return $this->findOneByOrderId((int) $orderId);
    }
}
