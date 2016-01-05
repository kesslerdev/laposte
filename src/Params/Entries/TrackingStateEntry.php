<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class TrackingStateEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'tracking_state_code',
            'label',

        ];
    }

    public function getTrackingStateCode(){
        return $this->get('tracking_state_code');
    }

    public function getLabel(){
        return $this->get('label');
    }

}