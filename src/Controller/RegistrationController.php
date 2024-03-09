<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        // si deja connecté, redirection vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // j'instancie un nouvel objet user
        $user = new User();
        // je crée un formulaire d'inscription et l'associe à user
        $form = $this->createForm(RegistrationFormType::class, $user);
        // je gere la soumission du formulaire
        $form->handleRequest($request);

        // si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // envoie les données du User dans la BDD
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            // authentifie directement le user et le redirige vers la page d'accueil
            return $security->login($user, AppAuthenticator::class, 'main');
            
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
        // redirige vers la vue register
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
