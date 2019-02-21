<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    /**
     * @return Pokemon[]
     */
    public function findAllWithDescription()
    {
	    /*
	     * select pokemon.no_pokedex, pokemon.location, pokemon.image, pokemon.type1, pokemon.type2, pokemon.size, pokemon.weight, description.gen, description.description
	     * from pokemon
	     * inner join description on description.pokemon_id=pokemon.pokemon_id 
	     */
	    // write DQL
    }

    // Add joined requests for use in Pokemon pages here
    // Need attack_slot, attack and description

    public function pokemonDetailRequest(){
	/**
	 * pokemon : no_pokedex, hp, atk, def, spe, speed, location, image, type1, type2, size, weight
	 *
	 */
    }
    


    // /**
    //  * @return Pokemon[] Returns an array of Pokemon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pokemon
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
