<?php

namespace App\Controller;

use App\Service\ParkingService;
use App\Entity\Parking;
use App\Form\ParkingType;
use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
#[Route('admin')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'admin_dashboard', methods: ['GET'])]
    public function index(ParkingRepository $repoParking): Response
    {
        $parkingAll = $repoParking->findAll();

        return $this->render('admin/parking/show.html.twig', [
            'parkings' => $parkingAll,
        ]);
    }
    
    #[Route('/parking/new', name: 'admin_new', methods: ['GET', 'POST'])]
    public function create_parking(Request $request, ParkingService $service): Response
    {
        $parking = new Parking();
        $form = $this->createForm(ParkingType::class, $parking, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'parking_item',
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /*$nombre = $request->request->get('nombre');
            $direccion = $request->request->get('descripcion');
            $latitud = $request->request->get('latitud');
            $longitud = $request->request->get('longitud');

            $parking->setNombre($nombre);
            $parking->setDireccion($direccion);
            $parking->setLatitud($latitud);
            $parking->setLongitud($longitud);*/

            $service->save_parking($parking);

            $errors = array();
            return $this->render('admin/parking/show.html.twig', [
                    'parking' => $parking
            ]);
            
        }
        $errors = array();
        return $this->render('admin/parking/new.html.twig', [
                'parking' => $parking,
                'form' => $form->createView(),
                'error' => $errors
        ]);
    }

    #[Route('/parking/{id}', name: 'admin_parking_id', methods: ['GET'])]
    public function get_parking(int $id, ParkingService $service): Response
    {
        $parking = $service->get_parking($id);

        return $this->render('admin/parking/show.html.twig', [
            'parking' => $parking,
        ]);
    }
/*
    #[Route('/parking/edit/{id}', name: 'admin_edit_parking', methods: ['POST'])]
    public function edit_parking(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/parking/delete/{id}', name: 'admin_delete_parking', methods: ['POST'])]
    public function delete_parking(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }*/
}
