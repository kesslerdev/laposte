<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class OvertaxedAreaEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'code_start',
            'code_end',
            'overtaxed_code',
            'label',

        ];
    }

    public function getOvertaxedCode(){
        return intval($this->get('overtaxed_code'));
    }

    public function getStartAreaCode(){
        return intval($this->get('code_start'));
    }
    public function getEndAreaCode(){
        return intval($this->get('code_end'));
    }


    public function getLabel(){
        return $this->get('label');
    }

}