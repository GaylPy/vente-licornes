<?php

namespace APIRestLicorneBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use APIRestLicorneBundle\Entity\Client;

class LoadClientData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     *
    */
    public function load(ObjectManager $manager)
    {
        $toto = new Client();
        $toto->setNom('toto');
        $toto->setPrenom('toto');
        $toto->setDateNaissance(new \DateTime());

        $titi = new Client();
        $titi->setNom('titi');
        $titi->setPrenom('titi');
        $titi->setDateNaissance(new \DateTime());


        $manager->persist($toto);
        $manager->persist($titi);

        $manager->flush();
    }

}

