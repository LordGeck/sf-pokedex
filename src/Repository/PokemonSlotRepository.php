<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

class PokemonSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function findByUser($userId)
    {
        // find
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select(
            'p_s.iv',
            'p_s.ev',
            'p_s.new_atk',
            'p_s.new_def',
            'p_s.new_spe',
            'p_s.new_speed',
            'p_s.new_hp'
        )
            ->from('App\Entity\PokemonSlot', 'p_s')
            ->leftJoin('App\Entity\Pokemon', 'p', Join::WITH, 'p_s.no_pokedex=p.no_pokedex')
            ->andWhere('p_s.userId=:userId')
            ->setParameter('userId', (int)$userId);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * to implement
     */
    public function findByPokemon()
    {
        // see if useful
    }
}
