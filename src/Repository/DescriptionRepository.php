<?php

namespace App\Repository;

use App\Entity\Description;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Description|null find($id, $lockMode = null, $lockVersion = null)
 * @method Description|null findOneBy(array $criteria, array $orderBy = null)
 * @method Description[]    findAll()
 * @method Description[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Description::class);
    }

    /**
     * Serves for pokemon_detail template
     */
    public function findByPokemon($pokemonNo): ?Description
    {
	/**
	 * select description.description, description.gen
	 * from description
	 * inner join pokemon on pokemon.pokemon_id=description.pokemon_id
	 * where description.pokemon_id=:pokemonNo 
	 */
	    // write DQL
	    
    }

    // /**
    //  * @return Description[] Returns an array of Description objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Description
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
