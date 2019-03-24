<?php

namespace App\Controller;


use App\Entity\Activity;
use App\Entity\GoodResponses;
use App\Entity\Questions;
use App\Entity\Reponses;
use App\Entity\UserActivity;
use App\Form\ActivityType;
use App\Form\GoodAnswerType;
use App\Form\QuestionType;
use App\Repository\ActivityRepository;
use App\Repository\QuestionsRepository;
use App\Repository\UserActivityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    /**
     * @Route("/activity", name="activity")
     */
    public function showActivities(ActivityRepository $activityRepository)
    {
        $activities = $activityRepository->findBy(['visible' => true]);

        return $this->render('activity/index.html.twig', [
            'activites' => $activities,
            'current_menu' => 'activity'
        ]);
    }

    //public function

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

            $activity->setCreatedBy($this->getUser());

            $manager->persist($activity);

            $manager->flush();

            if(!$id){
                return $this->redirectToRoute('activity_questions_new', ['id' => $activity->getId()]);
            }else {
                $this->addFlash('success', 'Activité modifiée avec succès');
                return $this->redirectToRoute('activity_questions', ['id' => $activity->getId()]);
            }


        }



        return $this->render('activity/new.html.twig', [
                'form_act' => $form->createView(),
                'activity' => $activity
        ]);
    }


    /**
     * @Route("/activity/{id}/qcm", name="activity_questions")
     */
    public function activity($id, ActivityRepository $activityRepository, ObjectManager $manager, UserActivityRepository $userActivityRepository){

        if(!$this->getUser()){
            $this->addFlash('error', 'Il faut se connecter pour faire l\'activité');

            return $this->redirectToRoute('activity');
        }

        //$user_activity = new UserActivity();

        $activities = $activityRepository->findOneby(['id' => $id]);

        $user = $this->getUser();

        $user_activity = $userActivityRepository->findOneby(['user_id' => $user, 'activity_id' => $activities->getId()]);

        if(!$user_activity){
            $user_activity = new UserActivity();
        }

        $user_activity->setUserId($user);
        $user_activity->setActivityId($activities);

        $manager->persist($user_activity);
        $manager->flush();


        $tab=['question.bonneReponse1', 'question.bonneReponse2', 'question.bonneReponse3', 'question.mauvaiseReponse1', 'question.mauvaiseReponse2', 'question.mauvaiseReponse3'];

        return $this->render('activity/activity.html.twig', [
            'activities' => $activities,
            'tab' => $tab
        ]);
    }

    /**
     * @Route("{id}/verification/qcm", name="verification_qcm")
     */
    public function verification($id, Request $request, QuestionsRepository $questionRepository, UserActivityRepository $userActivityRepository, ObjectManager $manager){

        $point = 0;
        $total = 0;
        $questionPrecedente = '';
        $tab = $request->request->all();

        $user_activity = $userActivityRepository->findOneby(['user_id' => $this->getUser(), 'activity_id' => $id]);

        while ($reponse = current($tab)){

            $questionIS = str_replace("_", " ", substr(key($tab), 2 ));//je récupère la question
            $question = $questionRepository->findOneBy(['question' => $questionIS]);//je vais chercher les bonnes réponses liées à la question

            if($questionIS == $questionPrecedente){
                $idem = true;
            }else {
                $idem = false;
            }

            if($idem == false){
                $total = $total + $question->getPoints();
            }

            if(in_array($reponse, [$question->getBonneReponse1(), $question->getBonneReponse2(), $question->getBonneReponse3()])){
                $point++;
            }else {
                $point = $point-0.2;
            }
            next($tab);
            $questionPrecedente = $questionIS;
        }

        $user_activity->setPoint($point);

        $manager->persist($user_activity);
        $manager->flush();

        return $this->render('activity/retour.html.twig', [
            'point' => $point,
            'total' => $total,
            'id' => $id
        ]);
    }

    /**
     * @param Activity $activity
     * @param ObjectManager $manager
     * @Route("/activity/{id}/delete", name="activity_delete")
     */
    public function delete($id, ActivityRepository $activityRepository, ObjectManager $manager){

        $activities = $activityRepository->findOneby(['id' => $id]);
        $manager->remove($activities);
        $manager->flush();
        return $this->redirectToRoute('activity');
    }
}
