<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        // je recupere toutes les sessions en BDD
        $sessions = $sessionRepository->findAll();

        // je retourne la vue avec la fonction symfony render()
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            // je transmets les infos recupérées plus haut
            'sessions' => $sessions
        ]);
    }
    
    #[Route('/session/{id}/details', name: 'details_session')]
    public function details(Session $session=null): Response
    {
        // $session = $sessionRepository->find($id);
        return $this->render('session/details.html.twig', [
            'controller_name' => 'SessionController', 
            'session' => $session
        ]);
    }

    #[Route('/session/new', name: 'new_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new_edit(Session $session = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$session) {
            $session = new Session();
        }
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $session->setCreateur($user);
            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/new.html.twig' , [
            'formAddSession' => $form,
            'edit' => $session->getId()
        ]);
    }
}
