<?php

namespace App\Controller;

use App\Entity\FormationSessions;
use App\Form\FormationSessionsType;
use App\Repository\FormationSessionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard_index', methods: ['GET'])]
    public function index(FormationSessionsRepository $formationSessionsRepository): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'formation_sessions' => $formationSessionsRepository->findAllByFormation(),
        ]);
    }

    #[Route('/new', name: 'app_dashboard_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormationSessionsRepository $formationSessionsRepository): Response
    {
        $formationSession = new FormationSessions();
        $form = $this->createForm(FormationSessionsType::class, $formationSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationSessionsRepository->add($formationSession, true);

            return $this->redirectToRoute('app_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/new.html.twig', [
            'formation_session' => $formationSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dashboard_show', methods: ['GET'])]
    public function show(FormationSessions $formationSession): Response
    {
        return $this->render('dashboard/show.html.twig', [
            'formation_session' => $formationSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dashboard_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FormationSessions $formationSession, FormationSessionsRepository $formationSessionsRepository): Response
    {
        $form = $this->createForm(FormationSessionsType::class, $formationSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formationSessionsRepository->add($formationSession, true);

            return $this->redirectToRoute('app_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/edit.html.twig', [
            'formation_session' => $formationSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dashboard_delete', methods: ['POST'])]
    public function delete(Request $request, FormationSessions $formationSession, FormationSessionsRepository $formationSessionsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formationSession->getId(), $request->request->get('_token'))) {
            $formationSessionsRepository->remove($formationSession, true);
        }

        return $this->redirectToRoute('app_dashboard_index', [], Response::HTTP_SEE_OTHER);
    }
}
