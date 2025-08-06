<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParkingRepository;
use App\Entity\Parking;

class ParkingService{
    private $entityManager;
    private $parkingRepository;

    public function __construct(EntityManagerInterface $entityManager, ParkingRepository $parkingRepository){
        $this->entityManager = $entityManager;
        $this->parkingRepository = $parkingRepository;
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