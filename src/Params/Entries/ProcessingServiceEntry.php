<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class ProcessingServiceEntry extends ParamsEntryBase
{
    const LOGO_SUIVI = 1;
    const LOGO_SIGNE = 2;

    const TYPE_IDT = 1;
    const LOGO_IDS = 2;


    protected function getColumns(){
        return [
            'processing_service_code',
            'label',
            'type_id',
            'type_logo',
            'electronic_report',
            'paper_report',

        ];
    }

    public function getProcessingServiceCode(){
        return $this->get('processing_service_code');
    }

    public function getLabel(){
        return $this->get('label');
    }

    public function getIDType(){
        return intval($this->get('type_id'));
    }

    public function getLogoType(){
        return intval($this->get('type_logo'));
    }

    public function canReportByPaper(){
        return $this->get('paper_report') == 1;
    }
    public function canReportByWS(){
        return $this->get('electronic_report') == 1;
    }

}