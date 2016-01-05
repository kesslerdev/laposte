<?php

namespace Skimia\LaPoste\Params\Entries;


use Skimia\LaPoste\Params\ParamsEntryBase;

class AuthorizedDestinationEntry extends ParamsEntryBase
{


    protected function getColumns(){
        return [
            'product_code',
            'code_start',
            'code_end',

        ];
    }

    public function getProductCode(){
        return $this->get('product_code');
    }

    public function getStartAreaCode(){
        return intval($this->get('code_start'));
    }
    public function getEndAreaCode(){
        return intval($this->get('code_end'));
    }

    /**
     * @return ProductEntry
     */
    public function getProduct(){
        return $this->base->getProducts()->findById($this->getProductCode());
    }

    /**
     * @return AreaEntry
     */
    public function getStartArea(){
        return $this->base->getAreas()->findById($this->getStartAreaCode());
    }

    /**
     * @return AreaEntry
     */
    public function getEndArea(){
        return $this->base->getAreas()->findById($this->getEndAreaCode());
    }
}