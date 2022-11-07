<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\FAQRepository;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutUsController extends AbstractController
{
    #[Route('/actualites', name: 'app_news')]
    public function news(NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findAll();

        return $this->render('aboutUs/news/index.html.twig', [
            'news' =>$news,
        ]);
    }

    #[Route('/actualites/{id}', name: 'app_new_show', methods: ['GET'])]
    public function show(News $news): Response
    {
        return $this->render('aboutUs/news/show.html.twig', [
            'new' => $news,
        ]);
    }

    #[Route('/foire-aux-questions', name: 'app_faq')]
    public function faq(FAQRepository $FAQRepository): Response
    {
        $faqs = $FAQRepository->findAll();

        return $this->render('aboutUs/faq.html.twig', [
            "faqs" => $faqs,
        ]);
    }

    #[Route('/a-propos-de-nous', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        return $this->render('aboutUs/aboutUs.html.twig', []);
    }
}
