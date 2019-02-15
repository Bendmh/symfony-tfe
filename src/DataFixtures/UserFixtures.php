<?php

namespace App\DataFixtures;

use App\Entity\Classes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        /*$tab = ['1a', '2a'];

        for($i=0; $i < 2; $i++){
            $classes = new Classes();

            $classes->setNom($tab[$i]);

            $manager->persist($classes);

            $manager->flush();
        }*/

    }
}
