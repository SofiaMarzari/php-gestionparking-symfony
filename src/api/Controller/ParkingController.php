<?php

namespace App\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ParkingService;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/api/v1/parking')]
class ParkingController extends AbstractController
{
    private $service;

    public function __construct(ParkingService $service){
        $this->service = $service;
    }
    #[Route('/{id}', name: 'api_parking_id', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $parking = $this->service->get_parking($id);

        $data = $this->json([
            'ID' => $parking->getId(),
            'nombre' => $parking->getNombre(),
            'direccion' => $parking->getDireccion(),
            'latitud' => $parking->getLatitud(),
            'longitud' => $parking->getLongitud()
        ]);

        return $data;
    }
}