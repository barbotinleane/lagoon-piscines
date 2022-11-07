<?php

namespace App\Controller\dashboard;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/actualites')]
class NewsController extends AbstractController
{
    #[Route('/', name: 'app_news_index', methods: ['GET'])]
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('dashboard/news/index.html.twig', [
            'news' => $newsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_news_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NewsRepository $newsRepository, FileUploader $fileUploader): Response
    {
        $new = new News();
        $form = $this->createForm(NewsType::class, $new);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $imageName = $fileUploader->upload($imageFile);
                $new->setImageName($imageName);
            }

            $newsRepository->add($new, true);

            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/news/new.html.twig', [
            'news' => $new,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_news_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, News $new, NewsRepository $newsRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(NewsType::class, $new);
        $form->handleRequest($request);
        $oldImage = $new->getImageName();

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $oldFilePath = $this->getParameter('images_news_directory').'/'.$oldImage;
                if(file_exists($oldFilePath)) unlink($oldFilePath);
                $imageName = $fileUploader->upload($imageFile);
                $new->setImageName($imageName);
            }

            $newsRepository->add($new, true);

            return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/news/edit.html.twig', [
            'news' => $new,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_news_delete', methods: ['POST'])]
    public function delete(Request $request, News $news, NewsRepository $newsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $oldImage = $news->getImageName();
            $oldFilePath = $this->getParameter('images_news_directory').'/'.$oldImage;
            if(file_exists($oldFilePath)) unlink($oldFilePath);
            $newsRepository->remove($news, true);
        }

        return $this->redirectToRoute('app_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
