<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Form\FormateurType;
use App\Form\FormationType;
use App\Repository\FormateurRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    // CREATION/MODIFICATION D'UN MODULE
    #[Route('/admin/newFormation', name: 'new_formation')]
    #[Route('/admin/{id}/editFormation', name: 'edit_formation')]
    public function new_edit_formation(Formation $formation = null, 
                            Request $request, 
                            EntityManagerInterface $entityManager): Response
    {
        // si formation inexistante, crée un nouvel objet formation
        if (!$formation) {
            $formation = new Formation();
        }

        // crée un nouveau formulaire associé $formation
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        // si soumis et validé,
        // récupère les données du formulaire, et transmet à la BDD
        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $entityManager->persist($formation);
            $entityManager->flush();

            // redirige vers la page des formations
            return $this->redirectToRoute('app_formation');
        }

        return $this->render('formation/newFormation.html.twig' , [
            'formAddFormation' => $form,
            'edit' => $formation->getId()
        ]);
    }


    // CREATION/MODIFICATION D'UN MODULE
    #[Route('/admin/newFormateur', name: 'new_formateur')]
    #[Route('/admin/{id}/editFormateur', name: 'edit_formateur')]
    public function new_edit_formateur(Formateur $formateur = null, 
                            Request $request, 
                            EntityManagerInterface $entityManager): Response
    {
        // si formateur inexistante, crée un nouvel objet formateur
        if (!$formateur) {
            $formateur = new Formateur();
        }

        // crée un nouveau formulaire associé $formateur
        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formateur = $form->getData();
            $entityManager->persist($formateur);
            $entityManager->flush();

            // redirige vers la page des formateurs
            return $this->redirectToRoute('app_formation');
        }

        return $this->render('formation/newFormateur.html.twig' , [
            'formAddFormateur' => $form,
            'edit' => $formateur->getId()
        ]);
    }


}
