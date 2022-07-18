<?php

namespace App\Service;

use App\Entity\FormationAsks;
use App\Entity\ProjectAsk;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Routing\RouterInterface;

/***
 * Service used to send custom emails
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class CustomMailer
{
    private $mailer;
    private $router;

    public function __construct(TransportInterface $mailer, RouterInterface $router, AsanaManager $asana)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->asanaManager = $asana;
    }

    /***
     * Send an email which displays the informations of a formation ask made
     *
     * @param FormationAsks $ask
     * @param $status
     * @return RedirectResponse|void
     */
    public function sendAskMail(FormationAsks $ask, $status = null) {
        $stagiaires = [];
        if($ask->getStatus()->getId() == 1) {
            $stagiaires = $ask->getStagiaires();
        }

        $prerequisites = [];
        if($ask->getFormationLibelle()->getId() == 1) {
            $prerequisites = json_decode($ask->getPrerequisites(), true);
        }

        $email = (new TemplatedEmail())
            ->from('leanepublicite@gmail.com')
            ->to('formation@lagoon-piscines.com')
            ->subject('Nouvelle demande de formation !')
            ->htmlTemplate('email/email_ask.html.twig')
            ->context([
                'ask' => $ask,
                'stagiaires' => $stagiaires,
                'prerequisites' => $prerequisites,
                'status' => $status,
            ])
        ;

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return new RedirectResponse($this->router->generate('app_404_error'));
        }
    }

    public function sendProjectAskMail(ProjectAsk $projectAsk) {
        $email = (new TemplatedEmail())
            ->from('leanepublicite@gmail.com')
            ->to('leaneb83@gmail.com')
            ->subject('Nouvelle demande de devis !')
            ->htmlTemplate('email/email_project_ask.html.twig')
            ->context([
                'projectAsk' => $projectAsk,
            ])
        ;

        try {
            $emailSent = $this->mailer->send($email);
            dump($emailSent->getDebug());
        } catch (TransportExceptionInterface $e) {
            return new RedirectResponse($this->router->generate('app_404_error'));
        }
    }
}