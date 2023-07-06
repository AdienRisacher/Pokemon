<?php

namespace App\Repository;

use App\Entity\PokemonCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PokemonCollection>
 *
 * @method PokemonCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonCollection[]    findAll()
 * @method PokemonCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonCollection::class);
    }

    public function add(PokemonCollection $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PokemonCollection $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
