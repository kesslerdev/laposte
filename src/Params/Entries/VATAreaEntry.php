<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class VATAreaEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'min_postal_code',
            'max_postal_code',
            'code',
            'label',
            'start_date',

        ];
    }

    public function getCode(){
        return intval($this->get('code'));
    }

    public function getLabel(){
        return $this->get('label');
    }

    public function getMinPostalCode(){
        return intval($this->get('min_postal_code'));
    }

    public function getMaxPostalCode(){
        return intval($this->get('max_postal_code'));
    }

    public function getStartDate(){
        return new \DateTime($this->get('start_date'));
    }

}