<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // ici je definis ma route par defaut
    #[Route('/', name: 'app_home')]
    public function index(SessionRepository $sessionRepository): Response
    {

        $sessionsPasse = $sessionRepository->findSessionPassees();
        $sessionsPresent = $sessionRepository->findSessionPresent();
        $sessionsFutur = $sessionRepository->findSessionFutures();

        // dd($sessionsPresent);

        // je dis à mon controller d'afficher la vue home
        return $this->render('home/index.html.twig', [
            'sessionPasse' => $sessionsPasse,
            'sessionPresent' => $sessionsPresent,
            'sessionFutur' => $sessionsFutur,
            'controller_name' => 'HomeController',
        ]);
    }
}
