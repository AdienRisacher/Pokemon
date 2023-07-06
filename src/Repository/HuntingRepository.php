<?php

namespace App\Repository;

use App\Entity\Hunting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hunting>
 *
 * @method Hunting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hunting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hunting[]    findAll()
 * @method Hunting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HuntingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hunting::class);
    }

    public function add(Hunting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Hunting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
