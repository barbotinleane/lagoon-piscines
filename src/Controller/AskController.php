<?php

namespace App\Controller;

use App\Entity\Asks;
use App\Form\AsksType;
use App\Repository\DepartmentsRepository;
use App\Service\AskSaver;
use App\Service\CustomMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/***
 * Controller used to manage the ask for a formation
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class AskController extends AbstractController
{
    /***
     * Displays the form to ask for a formation, save the ask and send email
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param DepartmentsRepository $departmentsRepository
     * @param CustomMailer $mailer
     * @param AskSaver $askSaver
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    #[Route('/demande-de-formation', name: 'app_ask')]
    public function ask(EntityManagerInterface $entityManager, Request $request, DepartmentsRepository $departmentsRepository, CustomMailer $mailer, AskSaver $askSaver)
    {
        $ask = new Asks();
        $departments = $departmentsRepository->findAll();
        $form = $this->createForm(AsksType::class, $ask, ['departments' => $departments]);
        $form->handleRequest($request);

        if (!$request->isXmlHttpRequest()) {
            if ($form->isSubmitted() && $form->isValid()) {
                $askSaver->saveUnMappedFormFieldsToAsk($_POST, $ask);

                if($ask->getStagiaires() !== null) {
                    foreach ($ask->getStagiaires() as $stagiaire) {
                        $entityManager->persist($stagiaire);
                    }
                }
                $entityManager->persist($ask);
                $entityManager->flush();

                $mailer->sendAskMail($ask, $ask->getStatus());

                $this->addFlash('success', 'Votre demande de formation a bien été envoyée.');
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->renderForm('ask/ask.html.twig', [
            "form" => $form,
        ]);
    }
}
