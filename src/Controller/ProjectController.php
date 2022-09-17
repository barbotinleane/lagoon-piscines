<?php

namespace App\Controller;

use App\Entity\ProjectAsk;
use App\Form\ProjectAskType;
use App\Repository\DepartmentsRepository;
use App\Service\AsanaManager;
use App\Service\AskSaver;
use App\Service\CustomMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /***
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param DepartmentsRepository $departmentsRepository
     * @param CustomMailer $mailer
     * @param AskSaver $askSaver
     * @return Response
     */
    #[Route('/votre-projet', name: 'app_project')]
    public function index(EntityManagerInterface $entityManager, Request $request, DepartmentsRepository $departmentsRepository, AsanaManager $asanaManager, CustomMailer $mailer, AskSaver $askSaver): Response
    {
        $projectAsk = new ProjectAsk();
        $departments = $departmentsRepository->findAll();
        $form = $this->createForm(ProjectAskType::class, $projectAsk, ['departments' => $departments]);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest()) {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($projectAsk);
                $entityManager->flush();

                //$asanaManager->addProjectTask($projectAsk);
                $mailer->sendProjectAskMail($projectAsk);

                $this->addFlash('success', 'Votre demande de devis a bien été envoyée.');
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('project/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
