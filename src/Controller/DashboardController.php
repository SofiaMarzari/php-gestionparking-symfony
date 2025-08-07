<?php

namespace App\Controller;

use App\Service\ParkingService;
use App\Entity\Parking;
use App\Form\ParkingType;
use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $parkingAll = $repoParking->findAll();

        return $this->render('admin/parking/show.html.twig', [
            'parkings' => $parkingAll,
            'titulo' => 'Listado de Parkings'
        ]);
    }
    
    #[Route('/parking/new', name: 'admin_new', methods: ['GET', 'POST'])]
    public function create_parking(Request $request, ParkingService $service): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $parking = new Parking();
        $form = $this->createForm(ParkingType::class, $parking, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'parking_item',
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $latitud = $data->getLatitud();
            $longitud = $data->getLongitud();

            $isValidCoord = $service->validar_coordenadas($longitud, $latitud);
            if(!$isValidCoord){
                $errors = 'Coordenadas invalidas.';
                return $this->render('admin/parking/new.html.twig', [
                        'parking' => $parking,
                        'form' => $form->createView(),
                        'error' => $errors,
                        'action' => 'Crear'
                ]);
            }

            $service->save_parking($parking);

            $errors = array();
            return $this->render('admin/parking/show.html.twig', [
                    'parking' => $parking,
                    'action' => 'Crear',
                    'titulo' => 'Parking'
            ]);
            
        }
        $errors = array();
        return $this->render('admin/parking/new.html.twig', [
                'parking' => $parking,
                'form' => $form->createView(),
                'error' => $errors,
                'action' => 'Crear'
        ]);
    }

    #[Route('/parking/{id}', name: 'admin_parking_id', methods: ['GET'])]
    public function get_parking(int $id, ParkingService $service): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $parking = $service->get_parking($id);

        return $this->render('admin/parking/show.html.twig', [
            'parking' => $parking,
            'titulo' => 'Parking'
        ]);
    }

    #[Route('/parking/edit/{id}', name: 'admin_edit_parking', methods: ['GET', 'POST'])]
    public function edit_parking(int $id,Request $request, ParkingService $service): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $parking = $service->get_parking($id);


        $form = $this->createForm(ParkingType::class, $parking, [
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'parking_item',
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $latitud = $data->getLatitud();
            $longitud = $data->getLongitud();

            $isValidCoord = $service->validar_coordenadas($longitud, $latitud);
            if(!$isValidCoord){
                $errors = 'Coordenadas invalidas.';
                return $this->render('admin/parking/new.html.twig', [
                        'parking' => $parking,
                        'form' => $form->createView(),
                        'error' => $errors,
                        'action' => 'Editar'
                ]);
            }

            $service->save_parking($parking);

            $errors = array();
            return $this->render('admin/parking/show.html.twig', [
                    'parking' => $parking,
                    'titulo' => 'Parking'
            ]);
            
        }
        $errors = array();
        return $this->render('admin/parking/new.html.twig', [
                'parking' => $parking,
                'form' => $form->createView(),
                'error' => $errors,
                'action' => 'Editar'
        ]);
    }

    #[Route('/parking/delete/{id}', name: 'admin_delete_parking', methods: ['GET', 'DELETE'])]
    public function delete_parking(int $id, Request $request, ParkingService $service): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $parking = $service->get_parking($id);

        if($parking){
            $service->delete_parking($parking);
            $this->addFlash('message', 'Parking con ID('.$id.') eliminado con éxito.');
        }

        $errors = array();
        return $this->redirectToRoute('admin_dashboard');
    }
}
