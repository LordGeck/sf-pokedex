<?php

namespace App\Repository;

use App\Entity\AttackSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    /**
     * @return AttackSlot[]
     */
    public function findByPokemon($noPokedex)
    {
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->select(
            'a_s.level',
            'a_s.gen',
            'a.is_cs',
            'a.name',
            'a.type',
            'a.ct'
        )
            ->from('App\Entity\AttackSlot', 'a_s')
            // relationship to join, alias of join, expression, condition
            ->leftJoin('App\Entity\Attack', 'a', Join::WITH, 'a_s.attack_id=a.id')
            ->where('a_s.no_pokedex=:noPokedex')
            ->setParameter('noPokedex', (int)$noPokedex);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * @return AttackSlot[]
     */
    public function findByAttack($attackCode)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('a_s.level', 'a_s.gen', 'p.name')
            ->from('App\Entity\AttackSlot', 'a_s')
            // relationship to join, alias of join, expression, condition
            ->innerJoin('App\Entity\Pokemon', 'p')
            ->where('a_s.attack_code=:attackCode')
            ->setParameter('attackCode', (int)$attackCode);

        $query = $qb->getQuery();

        return $query->getResult();
    }
}
