<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="security")
     */
    public function index(Request $request, ObjectManager $manager)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        dump($user);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);

            $manager->flush();

            return $this->redirectToRoute('connexion');

        }

        return $this->render('security/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function home(){
        return $this->render('security/home.html.twig');
    }

    /**
     * @Route("/affichage", name="affichage")
     */
    public function affichageClasse(UserRepository $repo){

        $users = $repo->findBy(
            ['prenom' => 'pierre',
                'nom' => 'albert']
        );

        return $this->render('security/affichage.html.twig', [
            'users' => $users
        ]);
    }
}
