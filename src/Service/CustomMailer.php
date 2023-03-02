<?php

namespace App\Service;

use App\Entity\FormationAsks;
use App\Entity\ProjectAsk;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/***
 * Service used to send custom emails
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class CustomMailer
{
    private $mailer;
    private $router;
    private $twig;
    private $params;

    public function __construct(TransportInterface $mailer, RouterInterface $router, Environment $twig, ContainerBagInterface $params)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->twig = $twig;
        $this->params = $params;
    }

    /***
     * Send an email which displays the informations of a formation ask made
     *
     * @param FormationAsks $ask
     * @param $status
     * @return RedirectResponse|void
     */
    public function sendAskMail(FormationAsks $ask, $status = null) {
        $to = $this->params->get('formation_email_receiver');
        $subject = 'Nouvelle demande de formation !';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $content = $this->twig->render('email/email_ask.html.twig', [
            'ask' => $ask,
            'status' => $status,
        ]);

        mail($to, $subject, $content, implode("\r\n", $headers));
    }

    public function sendProjectAskMail(ProjectAsk $projectAsk) {
        $to = $this->params->get('project_email_receiver');
        $subject = 'Nouvelle demande de devis !';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $content = $this->twig->render('email/email_project_ask.html.twig', [
            'projectAsk' => $projectAsk,
        ]);

        mail($to, $subject, $content, implode("\r\n", $headers));
    }
}