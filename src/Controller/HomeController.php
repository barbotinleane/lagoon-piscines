<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /***
     * Called to display homepage
     *
     * @return Response
     */
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
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
