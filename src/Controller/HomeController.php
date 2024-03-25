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



        // APPARAMENT ON NE PEUT INTEGRER QU'UNE SEULE PAGINATION PAR VUE
        // DONC CA MARCHE PAS

        // Récupérer les sessions passées
        $sessionsPassees = $paginator->paginate(
            $sessionRepository->findSessionPassees(), // Query pour les sessions passées
            $request->query->getInt('page_passe', 1), // Numéro de page pour les sessions passées
            10 // Nombre d'éléments par page pour les sessions passées
        );

        
        $sessionsPresentes = $paginator->paginate(
            $sessionRepository->findSessionPresent(), 
            $request->query->getInt('page_present', 1),
            10,
            // j'ai trouvé ça sur stackoverflow mais ça fonctionne pas :/
            ['pageParameterName' => 'present']
        );

        
        $sessionsFutures = $paginator->paginate(
            $sessionRepository->findSessionFutures(),
            $request->query->getInt('page_futur', 1), 
            10,
            ['pageParameterName' => 'passe']
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
