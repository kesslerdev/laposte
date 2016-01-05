<?php

namespace Skimia\LaPoste\Params\Entries;

use Skimia\LaPoste\Params\ParamsEntryBase;

class AreaEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'min_postal_code',
            'max_postal_code',
            'area_code',
            'label',
        ];
    }

    public function getAreaCode(){
        return intval($this->get('area_code'));
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

}