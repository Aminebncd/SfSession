<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use App\Form\SessionType;
use App\Form\ProgrammeType;
use App\Repository\UserRepository;
use App\Repository\ModuleRepository;
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


    


    // CREATION/MODIFICATION D'UNE SESSION
    #[Route('/session/new', name: 'new_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new_edit(Session $session = null, 
                            Request $request, 
                            EntityManagerInterface $entityManager): Response
    {
        // si session inexistante, crée un nouvel objet session
        if (!$session) {
            $session = new Session();
        }

        // crée un nouveau formulaire associé $session
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        // si soumis et validé, attribue à session.createur l'id du user connecté, récupère les données du formulaire, et transmet à la BDD
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $session->setCreateur($user);
            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            // redirige vers la page des sessions
            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/new.html.twig' , [
            'formAddSession' => $form,
            'edit' => $session->getId()
        ]);
    }





    // AFFICHAGE DES DETAILS D'UNE SESSION
    #[Route('/session/{id}/details', name: 'details_session')]
    public function details(Session $session=null, 
                            Request $request,
                            SessionRepository $sessionRepository, 
                            Programme $programme = null
                            ): Response
    {
        $nonInscrits = $sessionRepository->findNonInscrits($session->getId());
        // $nonProgrammes = $sessionRepository->findNonProgrammes($session->getId());
        $form = $this->createForm(ProgrammeType::class, $programme, ['session'=>$session]);
        $form->handleRequest($request);
        // $session = $sessionRepository->find($id);
        

        // return $this->redirectToRoute('details_session', ['id' => $session->getId()]);
        return $this->render('session/details.html.twig', [
            'controller_name' => 'SessionController', 
            'nonInscrits' => $nonInscrits,
            'session' => $session,
            'formAddProgramme' => $form,
            // 'nonProgrammes' => $nonProgrammes,
            'message' => ""
        ]);
    }



    
    // AJOUT D'UN STAGIAIRE A UNE SESSION
    #[Route('/admin/{session}/{user}/inscrire', name: 'addUser_session')]
    public function addUser(Session $session=null, 
                            User $user=null,
                            Programme $programme = null,
                            SessionRepository $sessionRepository, 
                            UserRepository $userRepository,
                            EntityManagerInterface $entityManager,
                            Request $request) 
    {
        $nonInscrits = $sessionRepository->findNonInscrits($session->getId());
        $nonProgrammes = $sessionRepository->findNonProgrammes($session->getId());

        $form = $this->createForm(ProgrammeType::class, $programme, ['session' => $session,]);
        $form->handleRequest($request);
        // dd(count($session->getInscrits()));
        // je m'assure qu'il y a assez de place dans la session
        if (count($session->getInscrits()) < $session->getNombrePlaces()) {
            // je rajoute le user dont j'ai recupéré l'id à la liste des inscrits
            $session->addInscrit($user);
    
            // j'envoie les données à ma BDD
            $entityManager->persist($session);
            $entityManager->flush();
    
            // Je retourne la vue des details de la session
            return $this->redirectToRoute('details_session', ['id' => $session->getId()]);
            // return $this->render('session/details.html.twig', [
            //     'controller_name' => 'SessionController', 
            //     'nonInscrits' => $nonInscrits,
            //     'session' => $session,
            //     'nonProgrammes' => $nonProgrammes,
            //     'formAddProgramme' => $form,
            //     'message' => "Stagiaire ajouté avec succès."
            // ]);
        } else {
            return $this->redirectToRoute('details_session', ['id' => $session->getId()]);
            // return $this->render('session/details.html.twig', [
            //     'controller_name' => 'SessionController', 
            //     'nonInscrits' => $nonInscrits,
            //     'formAddProgramme' => $form,
            //     'session' => $session,
            //     'message' => "Session pleine."
            // ]);
        }
       
    }





    // AJOUT D'UN MODULE A UNE SESSION
    #[Route('/admin/{session}/programmer', name: 'addModule_session')]
    public function addModule(Session $session=null, 
                              Module $module=null,
                              Programme $programme = null,
                              SessionRepository $sessionRepository, 
                            //   ModuleRepository $moduleRepository,
                              EntityManagerInterface $entityManager,
                              Request $request) : Response
    {
        $nonInscrits = $sessionRepository->findNonInscrits($session->getId());
        $nonProgrammes = $sessionRepository->findNonProgrammes($session->getId());
        
        $programme = new Programme();
        $form = $this->createForm(ProgrammeType::class, $programme, ['session' => $session,]);
        $form->handleRequest($request);

        // dd($programme); 
        if ($form->isSubmitted() && $form->isValid()) {
            $programme->setSesion($session);
            $programme = $form->getData();
            // $session->addProgramme($programme);
            $entityManager->persist($programme);
            $entityManager->flush();

            return $this->render('session/index.html.twig', [
                    'controller_name' => 'SessionController', 
                    'formAddProgramme' => $form,
                    'nonInscrits' => $nonInscrits,
                    'session' => $session,
                    'nonProgrammes' => $nonProgrammes,
                    'message' => "Module ajouté avec succès."
                ]);
        }
    }






    // SUPPRESSION D'UN STAGIAIRE D'UNE SESSION
    #[Route('/admin/{session}/{user}/desinscrire', name: 'removeUser_session')]
    public function removeUser(Session $session=null, 
                            User $user=null,
                            Programme $programme = null,
                            SessionRepository $sessionRepository, 
                            UserRepository $userRepository,
                            EntityManagerInterface $entityManager,
                            Request $request)
    {
      
        $session->removeInscrit($user);
        $entityManager->persist($session);
        $entityManager->flush();
        
        $nonInscrits = $sessionRepository->findNonInscrits($session->getId());
        $nonProgrammes = $sessionRepository->findNonProgrammes($session->getId());

        $form = $this->createForm(ProgrammeType::class, $programme, ['session' => $session,]);
        $form->handleRequest($request);

        return $this->redirectToRoute('details_session', ['id' => $session->getId()]);

        // return $this->render('session/details.html.twig', [
        //     'controller_name' => 'SessionController',
        //     'formAddProgramme' => $form, 
        //     'nonInscrits' => $nonInscrits,
        //     'session' => $session,
        //     'nonProgrammes' => $nonProgrammes,
        //     'message' => "Stagiaire supprimé avec succès."
        // ]);
    }


}