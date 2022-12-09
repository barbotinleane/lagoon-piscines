<?php

namespace App\Controller\dashboard;

use App\Entity\FormationImages;
use App\Entity\FormationLibelles;
use App\Form\FormationLibellesType;
use App\Repository\FormationLibellesRepository;
use App\Service\FileUploader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/les-formations')]
class FormationLibellesController extends AbstractController
{
    #[Route('/', name: 'app_formation_libelles_index', methods: ['GET'])]
    public function index(FormationLibellesRepository $formationLibellesRepository): Response
    {
        return $this->render('dashboard/formations/index.html.twig', [
            'formation_libelles' => $formationLibellesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formation_libelles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormationLibellesRepository $formationLibellesRepository, FileUploader $fileUploader): Response
    {
        $formationLibelle = new FormationLibelles();
        $form = $this->createForm(FormationLibellesType::class, $formationLibelle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $file */
            $file = $request->files->get('formation_libelles');
            $formationImagesFiles = $file['formationImages'];

            if($formationImagesFiles) {
                foreach ($formationImagesFiles as $file) {
                    $file = $file["image"];
                    if($file !== null) {
                        $fileName = $fileUploader->upload($file, "/images/formations");
                        $formationImage = new FormationImages();
                        $formationImage->setImageName($fileName);
                        $formationImage->setFormation($formationLibelle);
                        $formationLibelle->addFormationImage($formationImage);
                    }
                }
                $formationImages = $formationLibelle->getFormationImages();
                foreach ($formationImages as $image) {
                    if ($image->getImageName() === null) {
                        $formationLibelle->removeFormationImage($image);
                    }
                }
            }

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageName')->getData();
            /** @var UploadedFile $programFile */
            $programFile = $form->get('programNameOfFile')->getData();

            if ($imageFile) {
                $imageName = $fileUploader->upload($imageFile, "/images/formations");
                $formationLibelle->setImage($imageName);
            }

            if ($programFile) {
                $programName = $fileUploader->upload($programFile, "/programs");
                $formationLibelle->setProgramName($programName);
            }

            $formationLibellesRepository->add($formationLibelle, true);

            return $this->redirectToRoute('app_formation_libelles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/formations/new.html.twig', [
            'formation_libelle' => $formationLibelle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formation_libelles_show', methods: ['GET'])]
    public function show(FormationLibelles $formationLibelle): Response
    {
        return $this->render('dashboard/formations/show.html.twig', [
            'formation_libelle' => $formationLibelle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formation_libelles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FormationLibelles $formationLibelle, EntityManagerInterface $em, FormationLibellesRepository $formationLibellesRepository, FileUploader $fileUploader): Response
    {
        $originalGoals = new ArrayCollection();
        foreach ($formationLibelle->getFormationGoals() as $goal) {
            $originalGoals->add($goal);
        }

        $originalImages = new ArrayCollection();
        foreach ($formationLibelle->getFormationImages() as $image) {
            $originalImages->add($image);
        }

        $form = $this->createForm(FormationLibellesType::class, $formationLibelle);
        $form->handleRequest($request);
        $oldImage = $formationLibelle->getImage();
        $oldProgram = $formationLibelle->getProgramName();
        $oldImages = $formationLibelle->getFormationImages();

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($originalGoals as $goal) {
                if (false === $formationLibelle->getFormationGoals()->contains($goal)) {
                    // remove the Formation from the Goal
                    $em->remove($goal);
                }
            }

            foreach ($originalImages as $image) {
                if (false === $formationLibelle->getFormationImages()->contains($image)) {
                    // remove the Formation from the Goal
                    $em->remove($image);
                }
            }

            /** @var UploadedFile|null $file */
            $file = $request->files->get('formation_libelles');
            $formationImagesFiles = $file['formationImages'];

            if($formationImagesFiles) {
                foreach ($formationImagesFiles as $file) {
                    $file = $file["image"];
                    if($file !== null) {
                        $fileName = $fileUploader->upload($file, "/images/formations");
                        $formationImage = new FormationImages();
                        $formationImage->setImageName($fileName);
                        $formationImage->setFormation($formationLibelle);
                        $formationLibelle->addFormationImage($formationImage);
                    }
                }
                $formationImages = $formationLibelle->getFormationImages();
                foreach ($formationImages as $image) {
                    if ($image->getImageName() === null) {
                        $formationLibelle->removeFormationImage($image);
                    }
                }
            }

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageName')->getData();
            /** @var UploadedFile $programFile */
            $programFile = $form->get('programNameOfFile')->getData();

            if ($imageFile) {
                $oldFilePath = $this->getParameter('upload_directory').'/images/formations/'.$oldImage;
                if(file_exists($oldFilePath)) unlink($oldFilePath);
                $imageName = $fileUploader->upload($imageFile, "/images/formations");
                $formationLibelle->setImage($imageName);
            }

            if ($programFile) {
                $oldFilePath = $this->getParameter('upload_directory').'/programs/'.$oldImage;
                if(file_exists($oldFilePath)) unlink($oldFilePath);
                $programName = $fileUploader->upload($programFile, "/programs");
                $formationLibelle->setProgramName($programName);
            }

            $formationLibellesRepository->add($formationLibelle, true);

            return $this->redirectToRoute('app_formation_libelles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/formations/edit.html.twig', [
            'formation_libelle' => $formationLibelle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formation_libelles_delete', methods: ['POST'])]
    public function delete(Request $request, FormationLibelles $formationLibelle, FormationLibellesRepository $formationLibellesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formationLibelle->getId(), $request->request->get('_token'))) {
            $formationLibellesRepository->remove($formationLibelle, true);
        }

        return $this->redirectToRoute('app_formation_libelles_index', [], Response::HTTP_SEE_OTHER);
    }
}
