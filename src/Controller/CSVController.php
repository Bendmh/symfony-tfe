<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\CSV;
use App\Entity\Questions;
use App\Form\CSVselectType;
use App\Form\CSVType;
use App\Repository\ActivityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CSVController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \League\Csv\Exception
     * @Route("/csv", name="import_csv")
     */
    public function csvImport(Request $request, ObjectManager $manager){

        //$step = 1;
        $csv = new CSV();
        $form = $this->createForm(CSVType::class, $csv);
        $form->handleRequest($request);
        $header = '';

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($csv);
            $manager->flush();

            return $this->redirectToRoute('import_csv_id', ['id' => $csv->getId()]);
        }

        return $this->render('index/csv.html.twig', [
            'header' => $header,
            'form_csv' => $form->createView(),
            //'step' => $step
        ]);
    }


    /**
     * @param null $id
     * @param CSV $csv
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \League\Csv\Exception
     * @Route("/csv/{id}", name="import_csv_id")
     */
    public function csvImportId($id = null, CSV $csv, Request $request, ObjectManager $manager){

        $projectDir = $this->getParameter('kernel.project_dir');
        $csvPath = $projectDir . "\public\csv\\" . $csv->getFile();
        $csvReturn = Reader::createFromPath($csvPath, 'r');
        $csvReturn->setHeaderOffset(0);
        $csvReturn->setDelimiter(';');
        $header = $csvReturn->getHeader();
        $size = sizeof($header);
        switch ($size){
            case 7 :
                $csv->setColumn7($header[6]);
            case 6 :
                $csv->setColumn6($header[5]);
            case 5 :
                $csv->setColumn5($header[4]);
            case 4 :
                $csv->setColumn4($header[3]);
            case 3 :
                $csv->setColumn3($header[2]);
            case 2 :
                $csv->setColumn2($header[1]);
            case 1 :
                $csv->setColumn1($header[0]);
                break;
            default :
                $this->addFlash('error', 'Le tableau a trop de colonne');
                $test = true;
                return $this->redirectToRoute('import_csv');

        }

        $form = $this->createForm(CSVselectType::class, $csv);
        $form->handleRequest($request);

        //$step = 2;

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($csv);
            $manager->flush();

            return $this->redirectToRoute('csv_final', ['id' => $id]);
        }

        return $this->render('index/csv.html.twig', [
            'form_csv' => $form->createView(),
            //'step' => $step
        ]);
    }

    /**
     * @Route("/csv/{id}/final", name="csv_final")
     * @throws \League\Csv\Exception
     */
    public function test($id = null, CSV $csv, ObjectManager $manager, ActivityRepository $repository, Request $request){

        $projectDir = $this->getParameter('kernel.project_dir');
        $csvPath = $projectDir . "\public\csv\\" . $csv->getFile();
        $csvReturn = Reader::createFromPath($csvPath, 'r');
        $csvReturn->setHeaderOffset(0);
        $csvReturn->setDelimiter(';');
        $records = $csvReturn->getRecords();
        foreach($records as $offset => $record){

            $activity = $repository->findOneBy(['name' => $record[$csv->getColumn1()] ]);

            if(!$activity){
                $activity = new Activity();
                $activity->setName($record[$csv->getColumn1()]);
            }
            $question = new Questions();
            if($csv->getColumn2()){
                $question->setQuestion($record[$csv->getColumn2()]);
            }
            if($csv->getColumn3()){
                $question->setBonneReponse1($record[$csv->getColumn3()]);
            }
            if($csv->getColumn4()){
                $question->setBonneReponse2($record[$csv->getColumn4()]);
            }
            if($csv->getColumn5()){
                $question->setMauvaiseReponse1($record[$csv->getColumn5()]);
            }
            if($csv->getColumn6()){
                $question->setMauvaiseReponse2($record[$csv->getColumn6()]);
            }
            $question->setPoints($record[$csv->getColumn7()]);

            $manager->persist($question);

            $activity->addQuestion($question);

            $manager->persist($activity);

            $manager->flush();
        }

        return $this->redirectToRoute('activity');
    }
}
