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

    /**
     * @return AttackSlot[]
     */
    public function findByPokemon($pokemonNo)
    {
	/**
	 * select attack_slot.level, attack_slot.gen, attack.name, attack.type
	 * from attack_slot
	 * inner join attack on attack_slot.attack_id=attack.id
	 * where attack_slot.pokemon_id=:pokemonNo
	 */
	    return $this->createQueryBuilder('a')
		    ->andWhere('a.pokemon_id = :val')
		    ->setParameter('val', $pokemonNo)
		    ->orderBy('a.level', 'ASC')
		    ->getQuery()
		    ->getResult();
    }

    /**
     * @return AttackSlot[]
     */
    public function findByAttack($attackId)
    {
	    /**
	     * select attack_slot.level, attack_slot.gen, pokemon.name
	     * from attack_slot
	     * inner join pokemon on attack_slot.pokemon_id=pokemon.id
	     * where attack_slot.attack_id=:attackId
	     */
	    // write DQL here
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
