<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class ReportableFieldEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'processing_service_code',
            'attribute',
            'state',

        ];
    }

    public function getProcessingServiceCode(){
        return $this->get('processing_service_code');
    }

    public function getAttribute(){
        return $this->get('attribute');
    }

    public function isRequired(){
        return $this->get('state') != '0';
    }

}