<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Personne;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->passwordEncoder = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {
        $users = [
            ['first_name' => 'Admin','last_name' => 'Admin','email' => 'admin@mail.com','roles' => ["ROLE_ADMIN"]],
            ['first_name' => 'user','last_name' => 'user','email' => 'user@mail.com','roles' => []],
        ];
        
        foreach ($users as $key => $value) {
            $user = new User();
            $personne = new Personne();
            $personne->setFirstName($value['first_name'])
            ->setLastName($value['last_name']);
            $user->setEmail($value['email']);
            $user->setIsVerified(true);
            // $user->setCle('123456');
            // $user->setPhoneNumber('770000000');
            $user->setPassword($this->passwordEncoder->hashPassword($user,'password'))
            ->setRoles($value['roles'])
            ->setPersonne($personne);
            $manager->persist($user);
            $this->addReference('user_'.$value['email'],$user);
        }
        $manager->flush();
    }
}
