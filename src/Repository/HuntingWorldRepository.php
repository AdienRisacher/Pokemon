<?php

namespace App\Repository;

use App\Entity\HuntingWorld;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HuntingWorld>
 *
 * @method HuntingWorld|null find($id, $lockMode = null, $lockVersion = null)
 * @method HuntingWorld|null findOneBy(array $criteria, array $orderBy = null)
 * @method HuntingWorld[]    findAll()
 * @method HuntingWorld[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HuntingWorldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HuntingWorld::class);
    }

    public function add(HuntingWorld $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HuntingWorld $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
