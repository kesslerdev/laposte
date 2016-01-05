<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\ParamsTableBase;
use Skimia\LaPoste\Params\Entries\ProductEntry;

class ProductsTable extends ParamsTableBase
{

    /**
     * @param $productId
     * @return ProductEntry
     */
    public function findById($productId){
        return $this->findBy($productId,0);
    }

    /**
     * @param $line
     * @return ProductEntry
     */
    protected function createObjectLine($line)
    {
        return new ProductEntry($line,$this->base);
    }
}