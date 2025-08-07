<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Parking;
use App\Entity\Estadistica;
use \DateTimeInterface;

class ParkingService{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function save_parking(Parking $parking) : void{
        $this->entityManager->persist($parking);
        $this->entityManager->flush();
    }

    public function validar_coordenadas(float $longitud, float $latitud): ?bool
    {
        return (($latitud >= -90) && ($latitud <= 90) && ($longitud >= -180) && ($longitud <= 180));
    }

    public function get_parking(int $id) : ?Parking{
        $repoParking = $this->entityManager->getRepository(Parking::class);
        return $repoParking->find($id);
    }
 
    public function get_parking_cercano(float $latitud, float $longitud) : array
    {
        $repoParking = $this->entityManager->getRepository(Parking::class);
        $data = $repoParking->findPointBy($latitud, $longitud);

        if(!isset($data)){
            $data['message'] = 'No existe ningun parking registrado.';
        }else{
           ($data['distancia'] > 500) ?  $data['message'] = 'El parking mas cercano se encuentra a una distancia mayor a 500 metros.' :  $data['message'] = '';
        }

        

        return $data;
    }

    public function delete_parking(Parking $parking)  : void
    {
        $this->entityManager->remove($parking);
        $this->entityManager->flush();
    }

    public function save_estadistica(float $latitud, float $longitud, DateTimeInterface $date){
        $estadistica = new Estadistica();

        $estadistica->setLatitud($latitud);
        $estadistica->setLongitud($longitud);
        $estadistica->setDate($date);

        $this->entityManager->persist($estadistica);
        $this->entityManager->flush();
    }

}
?>