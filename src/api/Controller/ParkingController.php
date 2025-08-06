<?php

namespace App\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Service\ParkingService;
use App\Entity\Estadistica;
use App\Entity\Parking;

#[IsGranted('ROLE_API')]
#[Route('/api/v1/parking')]
class ParkingController extends AbstractController
{
    private $service;

    public function __construct(ParkingService $service){
        $this->service = $service;
    }

    #[Route('/{id}', name: 'api_parking_id', requirements: ['id' => '\d+'], methods: ['GET'])]
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
    
    #[Route('/create', name: 'api_parking_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!$data){
            throw new BadRequestHttpException('JSON inválido');
        }

        if (empty($data['nombre']) || empty($data['direccion']) || empty($data['longitud']) || empty($data['latitud'])) {
            throw new BadRequestHttpException('Faltan campos obligatorios.');
        }

        $isValidCoord = $this->service->validar_coordenadas($data['longitud'], $data['latitud']);
        if(!$isValidCoord){
            throw new BadRequestHttpException('Coordenadas invalidas.');
        }

        $nom = $data['nombre'];
        $dir = $data['direccion'];
        $long = $data['longitud'];
        $lat = $data['latitud'];

        $parking = new Parking();
        $parking->setNombre($nom);
        $parking->setDireccion($dir);
        $parking->setLongitud($long);
        $parking->setLatitud($lat);

        $this->service->save_parking($parking);

        $data = $this->json([
            'message' => 'Creado con exito!'
        ]);

        return $data;
    }

    #[Route('/consultar', name: 'api_parking_consultar', methods: ['GET', 'POST'])]
    public function consultar(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!$data){
            throw new BadRequestHttpException('JSON inválido');
        }
        if (empty($data['latitud']) || empty($data['longitud'])) {
            throw new BadRequestHttpException('Faltan campos obligatorios');
        }

        $longitud = $data['longitud'];
        $latitud = $data['latitud'];


        $data = $this->service->get_parking_cercano($latitud, $longitud);

        return $this->json([
            'data' => $data
        ]);
    }


}