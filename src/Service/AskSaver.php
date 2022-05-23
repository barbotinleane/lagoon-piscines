<?php

namespace App\Service;

use App\Entity\Asks;

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
     * @param Asks $ask
     * @return void
     */
    public function savePrerequisites($data, Asks $ask) {
        if($data['asks']['prerequisites'] === "true") {
            $prerequisites = [
                'visseuse' => $data['visseuse'],
                'perceuse' => $data['perceuse'],
                'taloche' => $data['taloche'],
                'malaxeur' => $data['malaxeur'],
                'malaxeurv' => $data['malaxeurv'],
                'commentaires-outils' => $data['commentaires-outils']
            ];
            $ask->setPrerequisites(json_encode($prerequisites));
        } else {
            $ask->setPrerequisites(null);
        }
    }

    /***
     * Check if some values from checkboxs or radios are not from defined values but are given from an 'other' field
     * Save the custom values in an ask object
     *
     * @param $data
     * @param Asks $ask
     * @return void
     */
    public function saveCustomValuesInFields($data, Asks $ask) {
        foreach ($data['other'] as $key => $value) {
            if($value !== "") {
                switch($key) {
                    case 'status':
                        $ask->setStatus($value);
                        break;
                    case 'goal':
                        $ask->setGoal($value);
                        break;
                    case 'activityCategory':
                        $ask->setActivityCategory($value);
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
     * @param Asks $ask
     * @return Asks
     */
    public function saveUnMappedFormFieldsToAsk($data, Asks $ask) {
        $this->savePrerequisites($data, $ask);
        $this->saveCustomValuesInFields($data, $ask);

        return $ask;
    }
}