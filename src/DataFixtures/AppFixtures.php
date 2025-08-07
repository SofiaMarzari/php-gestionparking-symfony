<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        //WEB
        $adminIni = new User();
        $adminIni->setEmail('pruebaadmin@gmail.com');
        $adminIni->setRoles(['ROLE_ADMIN']);
        $adminIni->setPassword($this->passwordHasher->hashPassword($adminIni,'DashAdmin123'));

        $manager->persist($adminIni);

        //API
        $adminIni2 = new User();
        $adminIni2->setEmail('prueba-tecnica@gmail.com');
        $adminIni2->setRoles(['ROLE_API']);
        $adminIni2->setPassword($this->passwordHasher->hashPassword($adminIni2,'Admin123!'));

        $manager->persist($adminIni2);

        $manager->flush();
        
    }
}
