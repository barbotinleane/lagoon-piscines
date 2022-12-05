<?php

namespace App\Service;

use App\Entity\FormationAsks;
use App\Entity\ProjectAsk;
use Asana\Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
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

    public function __construct(ContainerBagInterface $params, RouterInterface $router, Environment $twig)
    {
        $this->asana = Client::accessToken($params->get('asana_key'));
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

        $workspaceId = '1201979099877005';
        $projectId = "1202210789483832";

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
                'name' => $ask->getFirstName().' '.$ask->getLastName(),
                'approval_status' => 'pending',
                'projects' => $projectId,
                'html_notes' => $html
            ), array(
                'headers' => [
                    'Asana-Disable' => 'new_project_templates',
                    'Asana-Enable' => 'new_user_task_lists',
                ],
                'fields' => ['html_notes'],
            ));
        } catch (\Exception $e) {
            return new RedirectResponse($this->router->generate('app_404_error'));
        }

        return $result;
    }

    public function addProjectTask(ProjectAsk $ask)
    {
        $workspaceId = '1201979099877005';

        // Test department and change project and subtasks
        if($ask->getDepartment() === "06") {
            $projectId = "1202086049265434";
            $subtasks = [
                "Prise de contact par téléphone",
                "Prise de RDV sur place",
                "Devis",
                "Présentation du devis"
            ];
        } else {
            $projectId = "1202086049265444";
            $subtasks = [
                "Envoi à l'applicateur",
                "Retour"
            ];
        }

        // Load Twig File
        $html = $this->twig->render('asana_task/project_task.html.twig', [
            'projectAsk' => $ask
        ]);

        //Create task
        $result = $this->asana->tasks->createTask(array(
            'workspace' => $workspaceId,
            'name'      => $ask->getFirstName().' '.$ask->getLastName(),
            'approval_status' => 'pending',
            'projects' => $projectId,
            'html_notes' => $html
        ), array(
            'headers' => [
                'Asana-Disable' => 'new_project_templates',
                'Asana-Enable' => 'new_user_task_lists',
            ],
            'fields' => ['html_notes'],
        ));

        //Create subtasks
        foreach ($subtasks as $subtask) {
            $task = $this->asana->tasks->createSubtaskForTask($result->gid, array(
                'name'      => $subtask,
                'approval_status' => 'pending',
            ), array(
                'opt_pretty' => 'true',
                'headers' => [
                    'Asana-Disable' => 'new_project_templates',
                    'Asana-Enable' => 'new_user_task_lists',
                ],
            ));
        }
    }
}