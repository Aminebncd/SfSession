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
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // on verifie que le user dispose de droits admin
        if(in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
            // trouve tous les users en BDD pour les afficher
            $users = $userRepository->findAll();
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
                'users' => $users
            ]);
        } else {
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    }

    // || in_array("ROLE_ADMIN", $this->getUser()->getRoles()) 
    #[Route('/user/{id}/details', name: 'details_user')]
    public function details(User $user=null): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // pas besoin de faire  $user = $userRepository->find($id); car symfony le fait tout seul

        // la fiche d'un stagiaire ne peut être consultée que par un admin ou le stagiaire lui même
        if ($user == $this->getUser() || in_array("ROLE_ADMIN", $this->getUser()->getRoles()) ){
            return $this->render('user/details.html.twig', [
                'controller_name' => 'UserController', 
                'user' => $user
            ]);
        }
    }



    #[Route('/user/{id}/edit', name: 'edit_user')]
    public function edit(User $user = null, 
    Request $request, 
    EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // crée un nouveau formulaire associé $categorie
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // si soumis et validé, 
        // récupère les données du formulaire, et transmet à la BDD
        if ($form->isSubmitted() 
            && $form->isValid()
                && (($user = $this->getUser()) || in_array("ROLE_ADMIN", $this->getUser()->getRoles()))) {
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

      // SUPPRESSION D'UN MODULE
      #[Route('/admin/{id}/delete', name: 'delete_user')]
      public function delete(User $user = null, EntityManagerInterface $em)
      {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
          if ($user) {
             $em->remove($user);
             $em->flush();
             return $this->redirectToRoute('app_user');
          } else {
              return $this->redirectToRoute('app_user');
          }
      }

   

}