<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\CSV;
use App\Entity\Questions;
use App\Entity\Reponses;
use App\Form\CSVselectType;
use App\Form\CSVType;
use App\Form\RegistrationType;
use App\Form\ReponsesType;
use App\Repository\ActivityRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Reader;
use function League\Csv\delimiter_detect;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'current_menu' => 'home'
        ]);
    }

    /**
     * @Route("/perso", name="perso")
     */
    public function perso(Request $request, ObjectManager $manager){

        $user = $this->getUser();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);

            $manager->flush();
        }

        return $this->render('index/perso.html.twig', [
            'form_user' =>$form->createView(),
            'user' => $user,
            'current_menu' => 'perso'
        ]);
    }

    /**
     * @param Reponses $reponses
     * @Route("/test", name="test")
     * @throws \League\Csv\Exception
     */
    public function test(ObjectManager $manager, ActivityRepository $repository, Request $request){

        $reponses = new Reponses();

        $form = $this->createForm(ReponsesType::class, $reponses);

        return $this->render('index/test.html.twig', [
            'current_menu' => 'perso',
            'form' => $form->createView()
        ]);

    }
}
