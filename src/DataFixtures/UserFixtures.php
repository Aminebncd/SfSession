<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {

            $sexe = ['homme', 'femme', 'autre'];
            $ville = ['strasbourg', 'mulhouse', 'colmar'];
            $dateNaissance = new \DateTime();
            $dateNaissance->setTimestamp(mt_rand(strtotime('1980-01-01'), strtotime('2005-12-31')));

           $user = new User();
           $user->setEmail('user'.$i.'@hotmail.com');
           $user->setPassword('ABC');
           $user->setNom('Fixture'.$i);
           $user->setPrenom('Data');
           $user->setDateNaissance($dateNaissance);
           $user->setSexe($sexe[array_rand($sexe, 1)]);
           $user->setVille($ville[array_rand($ville, 1)]);
           $user->setTelephone('0000000000');

            // Enregistrer la session dans la base de données
            $manager->persist($user);
        }

        $manager->flush();
    }
}
