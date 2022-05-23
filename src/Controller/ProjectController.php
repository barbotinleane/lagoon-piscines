<?php

namespace App\Controller;

use App\Entity\ProjectAsk;
use App\Form\AsksType;
use App\Form\ProjectAskType;
use App\Repository\DepartmentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/votre-projet', name: 'app_project')]
    public function index(DepartmentsRepository $departmentsRepository, Request $request): Response
    {
        $projectAsk = new ProjectAsk();
        $departments = $departmentsRepository->findAll();
        $form = $this->createForm(ProjectAskType::class, $projectAsk, ['departments' => $departments]);
        $form->handleRequest($request);

        return $this->render('project/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
