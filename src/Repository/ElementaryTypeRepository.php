<?php

namespace App\Repository;

use App\Entity\ElementaryType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ElementaryType>
 *
 * @method ElementaryType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElementaryType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElementaryType[]    findAll()
 * @method ElementaryType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementaryTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElementaryType::class);
    }

    public function add(ElementaryType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ElementaryType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
