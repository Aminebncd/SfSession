<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Session;
use App\Form\ModuleType;
use App\Entity\Categorie;
use App\Entity\Programme;
use App\Form\SessionType;
use App\Form\CategorieType;
use App\Form\ProgrammeType;
use App\Repository\UserRepository;
use App\Repository\ModuleRepository;
use App\Repository\SessionRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(ModuleRepository $moduleRepository, 
                          CategorieRepository $categorieRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // je recupere toutes les Modules en BDD
        $modules = $moduleRepository->findBy([], ['categorie' => 'ASC']);
        $categories = $categorieRepository->findAll();
       
        // je retourne la vue avec la fonction symfony render()
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
            // je transmets les infos recupérées plus haut
            'modules' => $modules,
            'categories' => $categories
        ]);
    }





    // CREATION/MODIFICATION D'UNE CATEGORIE
    #[Route('/admin/newCategorie', name: 'new_categorie')]
    #[Route('/admin/{id}/editCategorie', name: 'edit_categorie')]
    public function new_edit_categorie(Categorie $categorie = null, 
                            Request $request, 
                            EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // si categorie inexistante, crée un nouvel objet categorie
        if (!$categorie) {
            $categorie = new Categorie();
        }

        // crée un nouveau formulaire associé $categorie
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        // si soumis et validé, attribue à categorie.createur l'id du user connecté, récupère les données du formulaire, et transmet à la BDD
        if ($form->isSubmitted() 
            && $form->isValid()) {
            $categorie = $form->getData();
            $entityManager->persist($categorie);
            $entityManager->flush();

            // redirige vers la page des modules
            return $this->redirectToRoute('app_module');
        }

        return $this->render('module/newCategorie.html.twig' , [
            'formAddCategorie' => $form,
            'edit' => $categorie->getId()
        ]);
    }



    // CREATION/MODIFICATION D'UN MODULE
    #[Route('/admin/newModule', name: 'new_module')]
    #[Route('/admin/{id}/editModule', name: 'edit_module')]
    public function new_edit_module(Module $module = null,
                                    Request $request, 
                                    EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        // si module inexistante, crée un nouvel objet module
        if (!$module) {
            $module = new Module();
        }

        // crée un nouveau formulaire associé $module
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        // si soumis et validé, attribue à module.createur l'id du user connecté, récupère les données du formulaire, et transmet à la BDD
        if ($form->isSubmitted() && $form->isValid()) {
            $module = $form->getData();
            $entityManager->persist($module);
            $entityManager->flush();

            // redirige vers la page des modules
            return $this->redirectToRoute('app_module');
        }

        return $this->render('module/newModule.html.twig' , [
            'formAddModule' => $form,
            'edit' => $module->getId()
        ]);
    }




    #[Route('/module/{id}/details', name: 'details_categorie')]
    public function details(Categorie $categorie = null, 
                            Module $modules=null,
                            Request $request): Response
    {
        
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $modules = $categorie->getModules();
        return $this->render('module/details.html.twig', [
            'controller_name' => 'moduleController', 
            'categorie' => $categorie,
            'modules' => $modules
        ]);
    }
    
    
    
    
    // SUPPRESSION D'UN MODULE
    #[Route('/admin/{id}/deleteModule', name: 'delete_module')]
    public function deleteModule(Module $module = null, 
                                 EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($module) {
           $em->remove($module);
           $em->flush();
           return $this->redirectToRoute('app_module');
        } else {
            return $this->redirectToRoute('app_module');
        }
    }
    
    // SUPPRESSION D'UNE CATEGORIE
    #[Route('/admin/{id}/deleteCategorie', name: 'delete_categorie')]
    public function deleteCategorie(Categorie $categorie = null, 
                                    EntityManagerInterface $em)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($categorie) {
           $em->remove($categorie);
           $em->flush();
           return $this->redirectToRoute('app_module');
        } else {
            return $this->redirectToRoute('app_module');
        }
    }

   

}