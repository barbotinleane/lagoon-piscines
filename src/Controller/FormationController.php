<?php

namespace App\Controller;

use App\Entity\FormationAsks;
use App\Entity\Stagiaires;
use App\Form\FormationAsksType;
use App\Repository\DepartmentsRepository;
use App\Repository\FormationLibellesRepository;
use App\Repository\FormationPricesRepository;
use App\Repository\FormationSessionsRepository;
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
    #[Route('/nos-formations', name: 'app_formation')]
    public function index(FormationLibellesRepository $flRepo): Response
    {
        $formations = $flRepo->findAllToDisplayOnLagoonPiscines();

        return $this->render('formation/index.html.twig', [
            "formations" => $formations,
        ]);
    }

    #[Route('/nos-formations/{formationId}', name: 'app_formation_show')]
    public function show($formationId, FormationLibellesRepository $flRepo, FormationSessionsRepository $fsRepo): Response
    {
        $formation = $flRepo->find($formationId);
        $sessions = $fsRepo->findAllSessionsInChronologicalOrder($formationId);

        return $this->render('formation/show/index.html.twig', [
            "formation" => $formation,
            "sessions" => $sessions,
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
    #[Route('/demande-de-formation/{formationId}', name: 'app_formation_ask')]
    public function ask($formationId, EntityManagerInterface $em, FormationAskFlow $flow, FormationLibellesRepository $flRepo, CustomMailer $mailer, AsanaManager $asanaManager, AskSaver $askSaver)
    {
        $formation = $flRepo->find($formationId);

        $ask = new FormationAsks($formation);
        $flow->setGenericFormOptions(['formationId' => $formationId]);
        $flow->bind($ask);
        $form = $flow->createForm();
        $instance = $flow->getInstanceId();

        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                if ($flow->getCurrentStepLabel() === '3') {
                    $ask = $askSaver->saveUnMappedFormFieldsToAsk($_POST, $ask);
                }
                $form = $flow->createForm();
            } else {
                $ask->setFormationLibelle($formation);
                $em->persist($ask);
                $em->flush();

                $asanaManager->addFormationTask($ask);
                $mailer->sendAskMail($ask, $ask->getStatus());

                if($ask->getStatus()->getId() == 1) {
                    $this->addFlash('professional', 'Votre demande de formation a bien été envoyée.');
                } else {
                    $this->addFlash('individual', 'Votre demande de formation a bien été envoyée.');
                }
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('formation/ask/index.html.twig', [
            "form" => $form->createView(),
            "flow" => $flow,
            "ask" => $ask,
            "instance" => $instance,
            "formation" => $formation,
        ]);
    }
}
