<?php

namespace App\Repository;

use App\Entity\Chasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chasse>
 *
 * @method Chasse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chasse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chasse[]    findAll()
 * @method Chasse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chasse::class);
    }

    public function add(Chasse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Chasse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
