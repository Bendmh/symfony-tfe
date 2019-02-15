<?php

namespace App\Controller;


use App\Entity\Activity;
use App\Entity\GoodResponses;
use App\Entity\Questions;
use App\Form\ActivityType;
use App\Form\GoodAnswerType;
use App\Form\QuestionType;
use App\Repository\ActivityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    /**
     * @Route("/activity", name="activity")
     */
    public function index(ActivityRepository $activityRepository)
    {
        $activities = $activityRepository->findAll();

        return $this->render('activity/index.html.twig', [
            'activites' => $activities
        ]);
    }

    /**
     * @Route("/activity/new", name="new_activity")
     * @Route("/activity/{id}/edit", name="edit_activity")
     */
    public function create($id = null, Activity $activity = null, Request $request, ObjectManager $manager){

        if(!$activity){
            $activity = new Activity();
        }

        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($activity);

            $manager->flush();

            if(!$id){
                return $this->redirectToRoute('activity_questions_new', ['id' => $activity->getId()]);
            }else {
                return $this->redirectToRoute('activity_questions', ['id' => $activity->getId()]);
            }


        }



        return $this->render('activity/new.html.twig', [
                'form_act' => $form->createView(),
                'activite' => $activity->getId()
        ]);
    }


    /**
     * @Route("/activity/{id}/qcm", name="activity_questions")
     */
    public function activity($id, ActivityRepository $activityRepository){

        $activities = $activityRepository->findOneby(['id' => $id]);

        return $this->render('activity/activity.html.twig', [
            'activites' => $activities,
        ]);
    }

    /**
     * @Route("/verification", name="verification")
     */
    public function verification(Request $request, ActivityRepository $activityRepository){

        $activities = $activityRepository->findAll();

        dump($activities);
        //récupérer les valeurs du post
        /*$test = $request->request;
        dump($test->all()['Mauvaise_reponse_n°11']);*/
        return $this->render('activity/retour.html.twig');
    }
}
