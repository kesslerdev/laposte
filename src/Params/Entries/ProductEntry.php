<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class ProductEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'product_code',
            'label',
            'long_label',
            'vat',
            'min_use',
        ];
    }

    public function getProductCode(){
        return $this->get('product_code');
    }

    public function getLabel(){
        return $this->get('label');
    }

    public function getLongLabel(){
        return $this->get('long_label');
    }

    public function hasVAT(){
        return $this->get('vat') == 1;
    }

    public function getMinUse(){
        return intval($this->get('min_use'));
    }

}