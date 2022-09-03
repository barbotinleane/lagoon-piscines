<?php

namespace App\Service;

use App\Entity\Stagiaires;
use App\Form\FormationAsksType;
use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;

class FormationAskFlow extends FormFlow {
    protected $allowRedirectAfterSubmit = true;
    protected $allowDynamicStepNavigation = true;

    protected function loadStepsConfig() {
        return [
            [
                'label' => 'Mon Statut',
                'form_type' => FormationAsksType::class,
                'form_options' => [
                    'status' => $this->getFormData()->getStatus(),
                ],
            ],
            [
                'label' => 'Ma formation',
                'form_type' => FormationAsksType::class,
                'skip' => false,
            ],
            [
                'label' => 'Mes coordonnées',
                'form_type' => FormationAsksType::class,
                'skip' => false,
                'form_options' => [
                    'status' => $this->getFormData()->getStatus(),
                ],
            ],
            [
                'label' => 'Les Stagiaires',
                'form_type' => FormationAsksType::class,
                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    if ($flow->getFormData()->getStatus() === null) {
                        return true;
                    } else {
                        return $flow->getFormData()->getStatus()->getId() !== 1;
                    }
                },
                'form_options' => [
                    'status' => $this->getFormData()->getStatus(),
                ],
            ],
            [
                'label' => 'Coordonnées des stagiaires',
                'form_type' => FormationAsksType::class,
                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    if ($flow->getFormData()->isIsStagiaireMultiple() === true) {
                        return false;
                    } else {
                        return true;
                    }
                },
            ],
            [
                'label' => 'Autres renseignements',
                'form_type' => FormationAsksType::class,
            ],
        ];
    }

}