<?php

namespace App\DataFixtures;

use App\Entity\Abonnement;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AbonnementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $abonnement = new Abonnement();
        $abonnement->setUser($this->getReference('user_user@mail.com'));
        $abonnement->setDebut(new DateTime());
        $abonnement->setFin(new DateTime('+ 3 month'));
        $abonnement->setStatut('Activer');
        $abonnement->setTypeAbonnement($this->getReference('_type_abonnement_Standard'));
        $manager->persist($abonnement);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TypeAbonnementFixtures::class
        ];
    }
}
