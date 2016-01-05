<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class DepositOptionEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'option_code',
            'label',

        ];
    }

    public function getOptionCode(){
        return intval($this->get('option_code'));
    }

    public function getLabel(){
        return $this->get('label');
    }

}