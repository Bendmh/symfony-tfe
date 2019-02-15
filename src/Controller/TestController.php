<?php

namespace App\Controller;

use App\Entity\Lessons;
use App\Form\LessonsType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(Request $request, ObjectManager $manager)
    {
        $lesson = new Lessons();

        $form = $this->createForm(LessonsType::class, $lesson);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($lesson);

            $manager->flush();

            return $this->redirectToRoute('connexion');

        }

        return $this->render('test/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
