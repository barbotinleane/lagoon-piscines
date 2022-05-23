<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/a-propos-de-nous', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        return $this->render('home/aboutUs.html.twig', []);
    }

    /***
     * Called when an error 404 is returned
     *
     * @return Response
     */
    #[Route('/404', name: 'app_404_error')]
    public function error()
    {
        return $this->render('home/404.html.twig');
    }
}
