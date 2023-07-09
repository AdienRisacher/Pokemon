<?php

namespace App\Repository;

use App\Entity\ChasseEmplacement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChasseEmplacement>
 *
 * @method ChasseEmplacement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChasseEmplacement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChasseEmplacement[]    findAll()
 * @method ChasseEmplacement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChasseEmplacementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChasseEmplacement::class);
    }

    public function add(ChasseEmplacement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ChasseEmplacement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
