<?php

namespace App\Repository;

use App\Entity\AttackSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Query\Expr\Join;

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
    public function findByPokemon($pokemonNo)
    {
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->select('a_s.level', 'a_s.gen', 'a.name', 'a.type')
            ->from('App\Entity\AttackSlot', 'a_s')
            // relationship to join, alias of join, expression, condition
            ->innerJoin('App\Entity\Attack', 'a')
            ->where('a_s.no_pokedex=:pokemonNo')
            ->setParameter('pokemonNo', (int)$pokemonNo);

        $query = $qb->getQuery();

        // debug
        dump($query->getSql());

        dump($query->getResult());

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

        // debug
        dump($query->getSql());

        return $query->getResult();
    }
}
