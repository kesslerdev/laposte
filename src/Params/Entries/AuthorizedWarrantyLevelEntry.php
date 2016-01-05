<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class AuthorizedWarrantyLevelEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'product_code',
            'code_processing_service',
            'warranty_level',
            'electronic_report',
            'paper_report',

        ];
    }

    public function getProductCode(){
        return $this->get('product_code');
    }
    public function getProcessingServiceCode(){
        return $this->get('code_processing_service');
    }
    public function getWarrantyLevel(){
        return $this->get('warranty_level');
    }


    public function canReportByPaper(){
        return $this->get('paper_report') == 1;
    }
    public function canReportByWS(){
        return $this->get('electronic_report') == 1;
    }


    /**
     * @return ProductEntry
     */
    public function getProduct(){
        return $this->base->getProducts()->findById($this->getProductCode());
    }
}