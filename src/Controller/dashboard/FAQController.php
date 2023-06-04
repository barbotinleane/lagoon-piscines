<?php

namespace App\Controller\dashboard;

use App\Entity\FAQ;
use App\Entity\FaqCategory;
use App\Form\FaqCategoryType;
use App\Form\FAQType;
use App\Repository\FaqCategoryRepository;
use App\Repository\FAQRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/foire-aux-questions')]
class FAQController extends AbstractController
{
    #[Route('/', name: 'app_faq_index', methods: ['GET'])]
    public function index(FAQRepository $fAQRepository): Response
    {
        return $this->render('dashboard/faq/index.html.twig', [
            'faqs' => $fAQRepository->findAll(),
        ]);
    }

    #[Route('/creer-categorie', name: 'app_faq_create_category', methods: ['GET', 'POST'])]
    public function generateForm()
    {
        // Generate and render the form here
        $faqCategory = new FaqCategory();
        $form = $this->createForm(FaqCategoryType::class, $faqCategory);

        $formCategoryHtml = $this->renderView('dashboard/faq/category/_form.html.twig', [
            'formCategoryHtml' => $form->createView(),
            'faq_category' => $faqCategory,
        ]);

        return new Response($formCategoryHtml);
    }

    #[Route('/supprimer-categorie', name: 'app_faq_delete_category', methods: ['POST'])]
    public function deleteCategory(Request $request, FaqCategoryRepository $faqCategoryRepository, FAQRepository $FAQRepository)
    {
        $faqCategory = $faqCategoryRepository->find($request->get("id"));
        $faqCategoryRepository->remove($faqCategory, true);

        $fAQ = new FAQ();
        $form = $this->createForm(FAQType::class, $fAQ);

        return $this->redirectToRoute('app_faq_new', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/enregistrer-categorie', name: 'app_faq_save_category', methods: ['POST', 'GET'])]
    public function saveCategory(Request $request, FaqCategoryRepository $faqCategoryRepository) {
        $faqCategory = new FaqCategory();
        $faq = new FAQ();
        $form = $this->createForm(FaqCategoryType::class, $faqCategory);
        $form->handleRequest($request);

        if($request->get("faq_category") && $form->isSubmitted() && $form->isValid()) {
            if(!$faqCategoryRepository->nameExists($faqCategory->getName())) {
                $faqCategoryRepository->save($faqCategory, true);
            }
        }

        return $this->redirectToRoute('app_faq_new', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/new', name: 'app_faq_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FAQRepository $fAQRepository, FaqCategoryRepository $faqCategoryRepository): Response
    {
        $fAQ = new FAQ();
        $form = $this->createForm(FAQType::class, $fAQ);
        $form->handleRequest($request);

        $categories = $faqCategoryRepository->findAll();
        $categoriesHasQuestions = [];
        foreach ($categories as $category) {
            $questions = false;
            if(!$category->getQuestions()->isEmpty()) {
                $questions = true;
            }
            $categoriesHasQuestions['faq_category_'.$category->getId()] = $questions;
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $fAQRepository->add($fAQ, true);

            return $this->redirectToRoute('app_faq_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/faq/new.html.twig', [
            'faq' => $fAQ,
            'form' => $form,
            'categoriesHasQuestions' => $categoriesHasQuestions,
        ]);
    }

    #[Route('/{id}', name: 'app_faq_show', methods: ['GET'])]
    public function show(FAQ $fAQ): Response
    {
        return $this->render('dashboard/faq/show.html.twig', [
            'faq' => $fAQ,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_faq_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FAQ $fAQ, FAQRepository $fAQRepository, FaqCategoryRepository $faqCategoryRepository): Response
    {
        $form = $this->createForm(FAQType::class, $fAQ);
        $form->handleRequest($request);

        $categories = $faqCategoryRepository->findAll();
        $categoriesHasQuestions = [];
        foreach ($categories as $category) {
            $questions = false;
            if(!$category->getQuestions()->isEmpty()) {
                $questions = true;
            }
            $categoriesHasQuestions['faq_category_'.$category->getId()] = $questions;
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $fAQRepository->add($fAQ, true);

            return $this->redirectToRoute('app_faq_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/faq/edit.html.twig', [
            'faq' => $fAQ,
            'form' => $form,
            'categoriesHasQuestions' => $categoriesHasQuestions,
        ]);
    }

    #[Route('/{id}', name: 'app_faq_delete', methods: ['POST'])]
    public function delete(Request $request, FAQ $fAQ, FAQRepository $fAQRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fAQ->getId(), $request->request->get('_token'))) {
            $fAQRepository->remove($fAQ, true);
        }

        return $this->redirectToRoute('app_faq_index', [], Response::HTTP_SEE_OTHER);
    }
}
