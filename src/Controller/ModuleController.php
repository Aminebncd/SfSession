<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Categorie;
use App\Form\ModuleType;
use App\Entity\Programme;
use App\Form\SessionType;
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
    public function index(ModuleRepository $moduleRepository, CategorieRepository $categorieRepository): Response
    {
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





    // CREATION/MODIFICATION D'UN MODULE
    #[Route('/module/new', name: 'new_module')]
    #[Route('/module/{id}/edit', name: 'edit_module')]
    public function new_edit(Module $module = null, 
                            Request $request, 
                            EntityManagerInterface $entityManager): Response
    {
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

        return $this->render('module/new.html.twig' , [
            'formAddModule' => $form,
            'edit' => $module->getId()
        ]);
    }


    #[Route('/module/{id}/details', name: 'details_module')]
    public function details(Module $module=null): Response
    {
        // pas besoin de faire  $module = $moduleRepository->find($id); car symfony le fait tout seul
        // dd($module->get)
        return $this->render('module/details.html.twig', [
            'controller_name' => 'moduleController', 
            'module' => $module
        ]);
    }
   

}