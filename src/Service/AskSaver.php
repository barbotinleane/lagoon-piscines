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
        $this->saveCustomValuesInFields($data, $ask);

        return $ask;
    }
}