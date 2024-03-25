<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Formateur;
use App\Entity\User;

class SessionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 30; $i++) {

            $formations = $manager->getRepository(Formation::class)->findAll();
            $formateurs = $manager->getRepository(Formateur::class)->findAll();
            $createur = $manager->getRepository(User::class)->findBy();
            // $createur = $this->getUser();
    
            $session = new Session();
            $session->setIntituleSession('Formation ' . ($i + 1));

            // Génération de dates de début et de fin aléatoires entre le 1er janvier 2024 et le 31 décembre 2024
            $dateDebut = new \DateTime();
            $dateDebut->setTimestamp(mt_rand(strtotime('2024-01-01'), strtotime('2024-12-31')));
            $session->setDateDebut($dateDebut);
            $dateFin = clone $dateDebut;
            $dateFin->modify('+' . mt_rand(1, 5) . ' days'); // Durée aléatoire entre 1 et 5 jours
            $session->setDateFin($dateFin);

            $session->setNombrePlaces(mt_rand(10, 50));

            // Choix aléatoire d'une formation parmi celles existantes
            $formation = $formations[array_rand($formations)];
            $session->setFormation($formation);

            // Choix aléatoire d'un formateur parmi ceux existants
            $formateur = $formateurs[array_rand($formateurs)];
            $session->setFormateur($formateur);

            // Liaison avec le créateur de session
            $session->setCreateur($createur);

            // Enregistrer la session dans la base de données
            $manager->persist($session);
        }

        $manager->flush();
    }
}
