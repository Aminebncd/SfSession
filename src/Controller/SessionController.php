<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Entity\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'sessions' => $sessions
        ]);
    }
    
    #[Route('/session/{id}/details', name: 'details_session')]
    public function details(Session $session=null): Response
    {
        // $session = $sessionRepository-find($id);
        return $this->render('session/details.html.twig', [
            'controller_name' => 'SessionController', 
            'session' => $session
        ]);
    }
}
