<?php

namespace App\Service;

use App\Entity\FormationAsks;

/***
 * Service used to save unmapped fields in the form to ask for a formation in a formation object
 *
 * @author Léane Barbotin <barbotinleane@gmail.com>
 */
class AskSaver
{
    /***
     * If they exists, save the prerequisites in json in the ask object
     *
     * @param $data
     * @param FormationAsks $ask
     * @return void
     */
    public function savePrerequisites($data, FormationAsks $ask) {
        $prerequisites = [
            'Visseuse' => $data['visseuse'],
            'Perceuse' => $data['perceuse'],
            'Taloche' => $data['taloche'],
            'Commentaires' => $data['commentaires-outils'],
        ];
        $ask->setPrerequisites(json_encode($prerequisites));
    }

    /***
     * Check if some values from checkboxs or radios are not from defined values but are given from an 'other' field
     * Save the custom values in an ask object
     *
     * @param $data
     * @param FormationAsks $ask
     * @return void
     */
    public function saveCustomValuesInFields($data, FormationAsks $ask) {
        foreach ($data['other'] as $key => $value) {
            if($value !== "") {
                switch($key) {
                    case 'goal':
                        $ask->setGoal($value);
                        break;
                    case 'activityCategory':
                        $activityCategory = $ask->getActivityCategory();
                        $activityCategory[] = $value;
                        $ask->setActivityCategory($activityCategory);
                        break;
                    case 'knowsUs':
                        $knowsUs = $ask->getKnowsUs();
                        $knowsUs[] = $value;
                        $ask->setKnowsUs($knowsUs);
                        break;
                    default:
                        break;
                }
            }
        }
    }

    /***
     * Use fonctions defined before to save all the added values to the ask object
     *
     * @param $data
     * @param FormationAsks $ask
     * @return FormationAsks
     */
    public function saveUnMappedFormFieldsToAsk($data, FormationAsks $ask) {
        $this->savePrerequisites($data, $ask);
        $this->saveCustomValuesInFields($data, $ask);

        return $ask;
    }
}