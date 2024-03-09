<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
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

}
