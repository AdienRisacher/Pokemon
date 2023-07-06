<?php

namespace App\Repository;

use App\Entity\PokemonType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;




/**
 * @method PokemonType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonType[]    findAll()
 * @method PokemonType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonType::class);
    }

    /**
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getStatsByType(){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT libelle as type, nb FROM ((SELECT type1_id  as type, count(type1_id ) as nb from pokemon_type GROUP BY type1_id )
UNION
(SELECT type2_id  as type, count(type2_id ) as nb from pokemon_type GROUP BY type2_id )) as tab LEFT JOIN elementary_type on type = id WHERE nb > 0';

        $stmt = $conn->prepare($sql);
        return $stmt->execute();
    }

    /**
     * @return PokemonType[] Returns an array of PokemonType objects
     */
    public function getNbEvo(){
        $t = $this->findBy(["evolution"=> true]);
        return sizeof($t);
    }

}
