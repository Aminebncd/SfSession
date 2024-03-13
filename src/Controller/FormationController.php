<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formateur;
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
        $sessions = $formation->getSession();
        return $this->render('formation/detailsFormation.html.twig', [
            'controller_name' => 'moduleController', 
            'formation' => $formation,
            'sessions' => $sessions
        ]);
    }


    #[Route('/formation/{id}/detailsFormateur', name: 'details_formateur')]
    public function detailsFormateur(Formateur $formateur = null, 
                                     Session $session=null,
                                     Request $request): Response
    {
        $sessions = $formateur->getSessions();
        // dd($sessions);
        return $this->render('formation/detailsFormateur.html.twig', [
            'controller_name' => 'moduleController', 
            'formateur' => $formateur,
            'sessions' => $sessions
        ]);
    }
}
