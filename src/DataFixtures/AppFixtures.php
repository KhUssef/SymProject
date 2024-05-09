<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Job;
use App\Entity\Experience;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function load(ObjectManager $manager): void
    {
        $passwordHasher = $this->passwordHasher;
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'ad.min@gmail.com']);
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                'idktbh'
            )
        );
        $manager->persist($user);
        $manager->flush();

    }
}
