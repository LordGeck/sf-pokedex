<?php

namespace App\Repository;

use App\Entity\Attack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @method Attack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attack[]    findAll()
 * @method Attack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttackRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Attack::class);
    }
}

