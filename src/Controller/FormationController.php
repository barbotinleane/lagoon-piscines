<?php

namespace App\Controller;

use App\Entity\FormationAsks;
use App\Form\FormationAsksType;
use App\Repository\DepartmentsRepository;
use App\Repository\FormationLibellesRepository;
use App\Service\AsanaManager;
use App\Service\AskSaver;
use App\Service\CustomMailer;
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
    public function ask(EntityManagerInterface $entityManager, Request $request, FormationLibellesRepository $formationLibellesRepository, DepartmentsRepository $departmentsRepository, CustomMailer $mailer, AsanaManager $asanaManager, AskSaver $askSaver)
    {
        $formation = $formationLibellesRepository->find(1);
        $ask = new FormationAsks($formation);
        $departments = $departmentsRepository->findAll();
        $form = $this->createForm(FormationAsksType::class, $ask, ['departments' => $departments]);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest()) {
            if ($form->isSubmitted() && $form->isValid()) {
                $askSaver->saveUnMappedFormFieldsToAsk($_POST, $ask);

                if($ask->getStagiaires() !== null) {
                    foreach ($ask->getStagiaires() as $stagiaire) {
                        $entityManager->persist($stagiaire);
                    }
                }
                $ask->setFormationLibelle($formation);
                $entityManager->persist($ask);
                $entityManager->flush();

                $asanaManager->addFormationTask($ask);
                $mailer->sendAskMail($ask, $ask->getStatus());

                $this->addFlash('success', 'Votre demande de formation a bien été envoyée.');
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->renderForm('formation/ask.html.twig', [
            "form" => $form,
        ]);
    }
}
