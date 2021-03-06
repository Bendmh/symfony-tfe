<?php
/**
 * Created by PhpStorm.
 * User: B
 * Date: 29-03-19
 * Time: 20:12
 */

namespace App\Controller;


use App\Entity\UserActivity;
use App\Repository\ActivityRepository;
use App\Repository\QuestionsReponsesRepository;
use App\Repository\UserActivityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

class ActivityDirectionController extends AbstractController
{
    /**
     * @Route("/activity/{id}/qcm", name="activity_QCM")
     * @param $id
     * @param ActivityRepository $activityRepository
     * @param ObjectManager $manager
     * @param UserActivityRepository $userActivityRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function activityQCM($id, ActivityRepository $activityRepository, ObjectManager $manager, UserActivityRepository $userActivityRepository){

        $user = $this->getUser();

        if(!$user){
            $this->addFlash('error', 'Il faut se connecter pour faire l\'activité');

            return $this->redirectToRoute('activity');
        }

        $activity = $activityRepository->findOneby(['id' => $id]);

        $user_activity = $userActivityRepository->findOneby(['user_id' => $user, 'activity_id' => $activity->getId()]);

        if(!$user_activity){
            $user_activity = new UserActivity();
        }

        $user_activity->setUserId($user);
        $user_activity->setActivityId($activity);

        $manager->persist($user_activity);
        $manager->flush();


        $tab=['question.bonneReponse1', 'question.bonneReponse2', 'question.bonneReponse3', 'question.mauvaiseReponse1', 'question.mauvaiseReponse2', 'question.mauvaiseReponse3'];

        return $this->render('activity/activity.html.twig', [
            'activity' => $activity,
            'tab' => $tab
        ]);
    }

    /**
     * @Route("/activity/{id}/regroupement", name="activity_regroupement")
     * @param $id
     * @param ActivityRepository $activityRepository
     * @param ObjectManager $manager
     * @param UserActivityRepository $userActivityRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function activityGroups($id, ActivityRepository $activityRepository, QuestionsReponsesRepository $questionsReponsesRepository, ObjectManager $manager, UserActivityRepository $userActivityRepository){

        $user = $this->getUser();

        if(!$user){
            $this->addFlash('error', 'Il faut se connecter pour faire l\'activité');

            return $this->redirectToRoute('activity');
        }

        $activity = $activityRepository->findOneby(['id' => $id]);

        $answers = $questionsReponsesRepository->findAnswerByActivity($id);

        $user_activity = $userActivityRepository->findOneby(['user_id' => $user, 'activity_id' => $activity->getId()]);

        if(!$user_activity){
            $user_activity = new UserActivity();
        }

        $user_activity->setUserId($user);
        $user_activity->setActivityId($activity);

        $manager->persist($user_activity);
        $manager->flush();

        return $this->render('questions_groupes/activity.html.twig', [
            'activity' => $activity,
            'answers' => $answers
        ]);
    }
}