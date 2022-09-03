<?php

namespace App\DataFixtures;

use App\Entity\TypeAbonnement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeAbonnementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $typeAbonnemnts = [
            [
                'name'=>'Standard',
                'montant'=>'1000',
                'qty'=>3
            ],
            [
                'name'=>'Intermédiare',
                'montant'=>'2000',
                'qty'=>7
            ],
            [
                'name'=>'Prémium',
                'montant'=>'3000',
                'qty'=>9
            ],
        ];
        foreach ($typeAbonnemnts as $key => $v) {
            $typeAbonnemnt = new TypeAbonnement();
            $typeAbonnemnt
                ->setDesignation($v['name'])
                ->setMontant($v['montant'])
                ->setNombreCv($v['qty']);
                $this->addReference('_type_abonnement_'.$v['name'],$typeAbonnemnt);
            $manager->persist($typeAbonnemnt);
        }

        $manager->flush();
    }
}
