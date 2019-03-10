<?php

namespace App\Repository;

use App\Entity\Description;
use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

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
     * @return Description[]
     * Serves for pokemon_detail template
     */
    public function findByPokemon($pokemonNo): ?Description
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('d.description', 'd.gen')
            ->from('description', 'd')
            ->innerJoin('pokemon', 'p', Expr\Join::ON, 'p.id=d.pokemon_id')
            ->where('d.pokemon_id=:pokemonNo')
            ->setParameter('pokemonNo', (int)$pokemonNo);

        $query = $qb->getQuery();

        // debug
        dump($query->getSql());

        return $query->getResult();
    }
}

