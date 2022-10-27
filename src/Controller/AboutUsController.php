<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutUsController extends AbstractController
{
    #[Route('/actualites', name: 'app_news')]
    public function index(): Response
    {
        return $this->render('aboutUs/news.html.twig', []);
    }

    #[Route('/foire-aux-questions', name: 'app_faq')]
    public function faq(): Response
    {
        return $this->render('aboutUs/faq.html.twig', []);
    }

    #[Route('/a-propos-de-nous', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        return $this->render('aboutUs/aboutUs.html.twig', []);
    }
}
