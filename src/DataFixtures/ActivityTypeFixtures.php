<?php

namespace App\DataFixtures;

use App\Entity\ActivityType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActivityTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $type = new ActivityType();

        $type->setName('QCM');

        $manager->persist($type);

        $type = new ActivityType();

        $type->setName('regroupement');

        $manager->persist($type);

        $manager->flush();
    }
}
