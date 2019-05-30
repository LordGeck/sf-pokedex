<?php

namespace App\Repository;

use App\Entity\Pokemon as Pokemon;
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
     * @return array
     */
    public function findAllWithDescription()
    {
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->select(
            'p.id',
            'p.no_pokedex',
            'p.location',
            'p.name',
            'p.image',
            'p.type1',
            'p.type2',
            'p.size',
            'p.weight',
            'p.description',
            'p.nature',
            'p.createdAt',
            'p.editedAt'
        )
            ->from('App\Entity\Pokemon', 'p');

        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @return array
     * For use in pokemon_detail view
     */
    public function findDetail($pokemonNo)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p.no_pokedex',
                    'p.hp',
                    'p.atk',
                    'p.def',
                    'p.spe',
                    'p.name',
                    'p.speed',
                    'p.size',
                    'p.weight',
                    'p.location',
                    'p.image',
                    'p.type1',
                    'p.type2',
                    'p.description',
                    'p.nature'
        )
            ->from('App\Entity\Pokemon', 'p')
            ->andWhere('p.no_pokedex = :pokemonNo')
            ->setParameter('pokemonNo', (int)$pokemonNo);

        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }
}

