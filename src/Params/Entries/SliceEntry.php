<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class SliceEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'slice_code',
            'label',
            'min',
            'max',
        ];
    }

    public function getSliceCode(){
        return intval($this->get('slice_code'));
    }

    public function getLabel(){
        return $this->get('label');
    }

    public function getMin(){
        return intval($this->get('min'));
    }

    public function getMax(){
        return intval($this->get('max'));
    }


}