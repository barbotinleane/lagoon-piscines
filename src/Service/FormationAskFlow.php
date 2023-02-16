<?php

namespace App\Service;

use App\Form\FormationAsksType;
use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;

class FormationAskFlow extends FormFlow {
    protected $allowRedirectAfterSubmit = true;
    protected $allowDynamicStepNavigation = false;

    protected function loadStepsConfig() {
        return [
            [
                'label' => '1',
                'form_type' => FormationAsksType::class,
            ],
            [
                'label' => '2',
                'form_type' => FormationAsksType::class,
            ],
            [
                'label' => '3',
                'form_type' => FormationAsksType::class,
                'form_options' => [
                    'status' => $this->getFormData()->getStatus(),
                ],
            ],
        ];
    }

}