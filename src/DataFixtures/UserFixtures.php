<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Usuario solo visualización  solo read, select
        $ver = new User();
        $ver->setEmail('ver@viajes.com');
        $ver->setRoles(['ROLE_VIEWER']);
        $ver->setPassword($this->passwordHasher->hashPassword($ver, 'solomiro'));
        $manager->persist($ver);

        // Usuario administrador, edit add update delete
        $admin = new User();
        $admin->setEmail('admin@viajes.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $manager->flush();
    }
}
