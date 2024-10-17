<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Message;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function save(Message $message): void
    {
        $em = $this->getEntityManager();
        $em->persist($message);
        $em->flush();
    }

    public function delete(Message $message): void
    {
        $em = $this->getEntityManager();
        $em->remove($message);
        $em->flush();
    }

    public function removeBeforeDate(DateTimeImmutable $date): void
    {
        $this->createQueryBuilder('m')
            ->delete(Message::class, 'm')
            ->where('m.createdAt < :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->execute();
    }
}
