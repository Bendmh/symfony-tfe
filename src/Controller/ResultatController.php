<?php

namespace App\Controller;

use App\Repository\UserActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResultatController extends AbstractController
{
    /**
     * @Route("/resultat", name="resultat")
     */
    public function index(UserActivityRepository $userActivityRepository)
    {
        $user_activity = $userActivityRepository->findAll();



        return $this->render('resultat/index.html.twig', [
            'user_activity' => $user_activity
        ]);
    }
}
