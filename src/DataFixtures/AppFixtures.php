<?php

namespace App\DataFixtures;

use App\Entity\Session;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            
            $session = new Session();
            $session->setIntituleSession('session '.$i);
            $session->setCreateur(mt_rand(1, 2));
            $session->setFormateur(mt_rand(1, 2));
            $session->setFormation(mt_rand(1, 3));
            $session->setNombrePlaces(mt_rand(10, 50));
            $session->setDateDebut('Y-m-d H:i:s', mt_rand(time(), strtotime('+2 years')));
            $session->setDateFin('Y-m-d H:i:s', mt_rand(time(), strtotime('+2 years')));
            $manager->persist($session);
        }
        $manager->flush();
    }
}
