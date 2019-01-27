<?php

namespace App\Repository;

use App\Entity\AttackSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AttackSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttackSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttackSlot[]    findAll()
 * @method AttackSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttackSlotRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttackSlot::class);
    }

    // /**
    //  * @return AttackSlot[] Returns an array of AttackSlot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttackSlot
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
