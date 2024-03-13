<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formation;
use App\Repository\FormateurRepository;
use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository,
                          FormateurRepository $formateurRepository): Response
    {

        $formations = $formationRepository->findAll();
        $formateurs = $formateurRepository->findAll();
        
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
            'formateurs' => $formateurs,
            'controller_name' => 'FormationController'
        ]);
    }

    #[Route('/formation/{id}/detailsFormation', name: 'details_formation')]
    public function detailsFormation(Formation $formation = null, 
                                     Session $session=null,
                                     Request $request): Response
    {
        $sessions = $formation->getsessions();
        return $this->render('module/details.html.twig', [
            'controller_name' => 'moduleController', 
            'formation' => $formation,
            'sessions' => $sessions
        ]);
    }
}
