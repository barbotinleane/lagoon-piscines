<?php

namespace App\Service;

use App\Entity\Asks;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
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

    public function __construct(MailerInterface $mailer, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->router = $router;
    }

    /***
     * Send an email which displays the informations of a formation ask made
     *
     * @param Asks $ask
     * @param $status
     * @return RedirectResponse|void
     */
    public function sendAskMail(Asks $ask, $status = null) {
        $stagiaires = [];
        if($ask->getStatus()->getId() == 1) {
            $stagiaires = $ask->getStagiaires();
        }

        $prerequisites = [];
        if($ask->getFormationLibelle()->getId() == 1) {
            $prerequisites = json_decode($ask->getPrerequisites(), true);
        }

        $email = (new TemplatedEmail())
            ->from('form@lagoon-formations.com')
            ->to('barbotinleane@gmail.com')
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
}