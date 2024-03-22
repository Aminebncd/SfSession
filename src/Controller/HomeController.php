<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    // ici je definis ma route par defaut
    #[Route('/', name: 'app_home')]
    public function index(Request $request, SessionRepository $sessionRepository, PaginatorInterface $paginator): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les sessions passées
        $sessionsPassees = $paginator->paginate(
            $sessionRepository->findSessionPassees(), // Query pour les sessions passées
            $request->query->getInt('page_passe', 1), // Numéro de page pour les sessions passées
            10 // Nombre d'éléments par page pour les sessions passées
        );

        // Récupérer les sessions présentes
        $sessionsPresentes = $paginator->paginate(
            $sessionRepository->findSessionPresent(), // Query pour les sessions présentes
            $request->query->getInt('page_present', 1), // Numéro de page pour les sessions présentes
            10 // Nombre d'éléments par page pour les sessions présentes
        );

        // Récupérer les sessions futures
        $sessionsFutures = $paginator->paginate(
            $sessionRepository->findSessionFutures(), // Query pour les sessions futures
            $request->query->getInt('page_futur', 1), // Numéro de page pour les sessions futures
            10 // Nombre d'éléments par page pour les sessions futures
        );

        // Retourner la vue avec les résultats paginés
        return $this->render('home/index.html.twig', [
            'sessionPasse' => $sessionsPassees,
            'sessionPresent' => $sessionsPresentes,
            'sessionFutur' => $sessionsFutures,
            'controller_name' => 'HomeController',
        ]);
    }
}
