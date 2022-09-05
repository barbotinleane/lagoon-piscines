<?php

namespace App\Controller;

use App\Entity\FormationAsks;
use App\Entity\Stagiaires;
use App\Form\FormationAsksType;
use App\Repository\DepartmentsRepository;
use App\Repository\FormationLibellesRepository;
use App\Repository\FormationPricesRepository;
use App\Service\AsanaManager;
use App\Service\AskSaver;
use App\Service\CustomMailer;
use App\Service\FormationAskFlow;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(): Response
    {
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }

    /***
     * Displays the form to ask for a formation, save the ask and send email
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param DepartmentsRepository $departmentsRepository
     * @param CustomMailer $mailer
     * @param AskSaver $askSaver
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    #[Route('/demande-de-formation', name: 'app_ask')]
    public function ask(EntityManagerInterface $em, FormationAskFlow $flow, Request $request, FormationLibellesRepository $flRepo, FormationPricesRepository $fpRepo, DepartmentsRepository $dRepo, CustomMailer $mailer, AsanaManager $asanaManager, AskSaver $askSaver)
    {
        $formation = $flRepo->find(1);
        $departments = $dRepo->findAll();
        $prices = $fpRepo->findAll();
        $pricesArray = [];

        foreach($prices as $price) {
            $pricesArray[$price->getNumberOfPeople()] = $price->getPrice();
        }

        $priceToShow = 0;

        $ask = new FormationAsks($formation);
        $flow->setGenericFormOptions(['departments' => $departments]);
        $flow->bind($ask);
        $form = $flow->createForm();

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                if($flow->getCurrentStep() === 5) {
                    if($flow->getFormData()->getStagiaires()->isEmpty()) {
                        $companyDirectorStagiaire = new Stagiaires();
                        $companyDirectorStagiaire->setFirstName($flow->getFormData()->getFirstName());
                        $companyDirectorStagiaire->setLastName($flow->getFormData()->getLastName());
                        $companyDirectorStagiaire->setEmail($flow->getFormData()->getEmail());
                        $companyDirectorStagiaire->setPhoneNumber($flow->getFormData()->getPhoneNumber());

                        $flow->getFormData()->addStagiaire($companyDirectorStagiaire);
                    }
                    $numberOfLearners = $flow->getFormData()->getStagiaires()->count();
                    $priceWhenNumberOfLearnersBigger = 0;
                    foreach($prices as $price) {
                        if($price->getNumberOfPeople() == $numberOfLearners) {
                            $priceToShow = $price->getPrice();
                        } elseif ($price->getNumberOfPeople() == 0) {
                            $priceWhenNumberOfLearnersBigger = $price->getPrice();
                        }
                    }
                    if($priceToShow == 0) {
                        $priceToShow = $priceWhenNumberOfLearnersBigger*$numberOfLearners;
                    }
                }

                // form for the next step
                $form = $flow->createForm();
            } else {
                $askSaver->saveUnMappedFormFieldsToAsk($_POST, $ask);

                if($ask->getStagiaires() !== null) {
                    foreach ($ask->getStagiaires() as $stagiaire) {
                        $em->persist($stagiaire);
                    }
                }
                $ask->setFormationLibelle($formation);
                $em->persist($ask);
                $em->flush();

                $asanaManager->addFormationTask($ask);
                $mailer->sendAskMail($ask, $ask->getStatus());

                $this->addFlash('success', 'Votre demande de formation a bien été envoyée.');
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('formation/ask.html.twig', [
            "form" => $form->createView(),
            "flow" => $flow,
            "prices" => $pricesArray,
            "priceForStagiairesSaved" => $priceToShow,
        ]);
    }
}
