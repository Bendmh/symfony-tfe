<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\BadResponses;
use App\Entity\GoodResponses;
use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i = 0; $i < 3; $i++){

            $activity = new Activity();

            $activity->setName('Activité n°' . $i);

            $manager->persist($activity);

            for($j=0; $j < mt_rand(2,4); $j++){

                $questions = new Questions();

                $questions->setQuestion('Question n°' . $j);
                $questions->setLink($activity);

                $manager->persist($questions);

                $badResponse = new BadResponses();

                $badResponse->setResponse1('Mauvaise reponse n°1' .$j);
                $badResponse->setResponse2('Mauvaise reponse n°2' .$j);
                $badResponse->setResponse3('Mauvaise reponse n°3' .$j);
                $badResponse->setResponse4('Mauvaise reponse n°4' .$j);
                $badResponse->setLink($questions);

                $goodResponse = new GoodResponses();

                $goodResponse->setResponse1('Bonne reponse n°1'.$j);
                $goodResponse->setResponse2('Bonne reponse n°2'.$j);
                $goodResponse->setResponse3('Bonne reponse n°3'.$j);
                $goodResponse->setResponse4('Bonne reponse n°4'.$j);
                $goodResponse->setGoodLink($questions);

                $manager->persist($badResponse);

                $manager->persist($goodResponse);

            }
        }

        $manager->flush();
    }
}
