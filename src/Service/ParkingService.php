<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Parking;

class ParkingService{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function save_parking(Parking $parking) : void{
        $this->entityManager->persist($parking);
        $this->entityManager->flush();
    }

    public function get_parking(int $id) : ?Parking{
        $repoParking = $this->entityManager->getRepository(Parking::class);
        return $repoParking->find($id);
    }
}
?>