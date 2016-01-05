<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class CombinationEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'product_code',
            'slice_code',
            'deposit_option_code',
            'processing_service_code',

        ];
    }

    public function getProductCode(){
        return $this->get('product_code');
    }

    public function getSliceCode(){
        return intval($this->get('slice_code'));
    }

    public function getDepositOptionCode(){
        return intval($this->get('deposit_option_code'));
    }

    public function getProcessingServiceCode(){
        return $this->get('processing_service_code');
    }

}