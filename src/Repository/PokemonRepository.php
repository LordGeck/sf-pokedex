<?php

namespace App\Repository;

use App\Entity\Pokemon as Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\PokemonSearch;

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
    public function findAllWithDescription(): array
    {
        return $this->findWithDescription()->getQuery()->getResult();
    }

    /**
     * @param PokemonSearch $search
     * @return Query
     */
    public function findAllWithDescriptionQuery(PokemonSearch $search): Query
    {
        $queryBuilder = $this->findWithDescription();

        if($search->getName()){
            $queryBuilder = $queryBuilder->andWhere('p.name = :name')
                ->setParameter('name', $search->getName());
        }
        if($search->getType1()){
            $queryBuilder = $queryBuilder->andWhere('p.type1 = :type1')
                ->setParameter('type1', $search->getType1());
        }
        if($search->getType2()){
            $queryBuilder = $queryBuilder->andWhere('p.type2 = :type2')
                ->setParameter('type2', $search->getType2());
        }

        return $queryBuilder->getQuery();
    }

    /**
     * @return QueryBuilder
     */
    private function findWithDescription(): QueryBuilder
    {
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder();
        return $qb->select(
            'p.id',
            'p.no_pokedex',
            'p.location',
            'p.name',
            'p.type1',
            'p.type2',
            'p.size',
            'p.weight',
            'p.description',
            'p.nature',
            'p.createdAt',
            'p.editedAt',
            'p.fileName'
        )
            ->from('App\Entity\Pokemon', 'p');
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
                    'p.type1',
                    'p.type2',
                    'p.description',
                    'p.nature',
                    'p.fileName'
        )
            ->from('App\Entity\Pokemon', 'p')
            ->andWhere('p.no_pokedex = :pokemonNo')
            ->setParameter('pokemonNo', (int)$pokemonNo);

        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }
}

