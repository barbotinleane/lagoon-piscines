<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/votre-projet', name: 'app_project')]
    public function index(): Response
    {
        return $this->render('project/index.html.twig', []);
    }
}
