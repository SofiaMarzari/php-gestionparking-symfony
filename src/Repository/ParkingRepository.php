<?php

namespace App\Repository;

use App\Entity\Parking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parking>
 *
 * @method Parking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parking[]    findAll()
 * @method Parking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParkingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parking::class);
    }

    public function findPointBy(float $latitud, float $longitud): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT *, 
                    (6371000 * 2 * ASIN(
                        SQRT(
                            POWER(SIN(RADIANS(latitud - :latitud) / 2), 2) +
                            COS(RADIANS(:latitud)) * COS(RADIANS(latitud)) *
                            POWER(SIN(RADIANS(longitud - :longitud) / 2), 2)
                        )
                    )) AS distancia
                FROM parking
                ORDER BY distancia ASC
                LIMIT 1'
        ;

        $stmt = $conn->prepare($sql);

        $result = $stmt->executeQuery([
            'latitud' => $latitud,
            'longitud' => $longitud,
        ]);

        return $result->fetchAssociative() ?: null;
    }
}
