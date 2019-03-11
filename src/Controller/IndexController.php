<?php

namespace App\Controller;

use App\Entity\Reponses;
use App\Form\RegistrationType;
use App\Form\ReponsesType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

        dump($user);

        $form->handleRequest($request);

        dump($form);

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
     */
    public function test(){

        $reponses = new Reponses();

        $form = $this->createForm(ReponsesType::class, $reponses);

        return $this->render('index/test.html.twig', [
            'current_menu' => 'perso',
            'form' => $form->createView()
        ]);

    }
}
