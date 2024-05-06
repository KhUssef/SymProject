<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Job;
use App\Entity\Experience;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'ad.min@gmail.com']);
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $manager->flush();
    }
}
