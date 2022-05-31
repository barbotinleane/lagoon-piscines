<?php

namespace App\Service;

use App\Entity\FormationAsks;
use Asana\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/***
 * Service used to send custom emails
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class AsanaManager
{
    private $asana;
    private $router;
    private $twig;

    public function __construct(RouterInterface $router, Environment $twig)
    {
        $this->asana = Client::accessToken("1/1201982160009227:2dcaa27ff26c3696011cffe21e09c708");
        $this->router = $router;
        $this->twig = $twig;
    }

    public function addFormationTask(FormationAsks $ask)
    {
        $status = $ask->getStatus()->getId();

        $stagiaires = [];
        if($ask->getStatus()->getId() == 1) {
            $stagiaires = $ask->getStagiaires();
        }

        $prerequisites = [];
        if($ask->getFormationLibelle()->getId() == 1) {
            $prerequisites = json_decode($ask->getPrerequisites(), true);
        }

        $workspaceId = '1202209729086808';
        $projectId = "1202209874110545";

        // Load Twig File
        $html = $this->twig->render('asana_task/formation_task.html.twig', [
            'ask' => $ask,
            'stagiaires' => $stagiaires,
            'prerequisites' => $prerequisites,
            'status' => $status,
        ]);

        // Create the task
        try {
            $result = $this->asana->tasks->createTask(array(
                'workspace' => $workspaceId,
                'name' => 'Nouvelle demande de formation',
                'approval_status' => 'pending',
                'projects' => $projectId,
                'html_notes' => $html
            ), array(
                'headers' => ['Asana-Disable' => 'new_project_templates',
                    'Asana-Enable' => 'new_user_task_lists',],
                'fields' => ['html_notes'],
            ));
        } catch (\Exception $e) {
            return new RedirectResponse($this->router->generate('app_404_error'));
        }

        return $result;
    }
}