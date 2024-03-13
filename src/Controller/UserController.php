<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        // trouve tous les users en BDD pour les afficher
        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users
        ]);
    }


    #[Route('/user/{id}/details', name: 'details_user')]
    public function details(User $user=null): Response
    {
        // pas besoin de faire  $user = $userRepository->find($id); car symfony le fait tout seul
        
        return $this->render('user/details.html.twig', [
            'controller_name' => 'UserController', 
            'user' => $user
        ]);
    }



    #[Route('/user/{id}/edit', name: 'edit_user')]
    public function edit(User $user = null, 
    Request $request, 
    EntityManagerInterface $entityManager): Response
    {
        // crée un nouveau formulaire associé $categorie
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // si soumis et validé, attribue à categorie.createur l'id du user connecté, récupère les données du formulaire, et transmet à la BDD
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();

            // redirige vers la page des modules
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/edit.html.twig' , [
            'formAddUser' => $form,
            'edit' => $user->getId()
        ]);
    }

   

}