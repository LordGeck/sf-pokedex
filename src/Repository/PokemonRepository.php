<?php

//require __DIR__.'/../../vendor/autoload.php';

namespace App\Repository;

use App\Entity\Pokemon as Pokemon;
use App\Entity\Description as Description;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Join;

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
        $qb->select('p.no_pokedex',
                    'p.location',
                    'p.name',
                    'p.image',
                    'p.type1',
                    'p.type2',
                    'p.size',
                    'p.weight',
                    'd.gen',
                    'd.description')
            ->from('App\Entity\Pokemon', 'p')
            // relationship to join, alias of join, expression, condition
            ->innerJoin('App\Entity\Description', 'd');

        $query = $qb->getQuery();

        // debug
        dump($query->getSql());

        return $query->getResult();
    }

    /**
     * @return array
     * For use in pokemon_detail view
     */
    public function findWithDesc($pokemonNo)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p.no_pokedex',
                    'p.hp',
                    'p.atk',
                    'p.def',
                    'p.spe',
                    'p.speed',
                    'p.size',
                    'p.weight',
                    'p.location',
                    'p.image',
                    'p.type1',
                    'p.type2',
                    'd.gen',
                    'd.description')
            ->from('App\Entity\Pokemon', 'p')
            ->innerJoin('App\Entity\Description', 'd')
            ->where('p.no_pokedex = :pokemonNo')
            ->setParameter('pokemonNo', (int)$pokemonNo);

        $query = $qb->getQuery();

        // debug
        dump($query->getSql());

        dump($query->getResult());

        return $query->getResult();
    }
}
