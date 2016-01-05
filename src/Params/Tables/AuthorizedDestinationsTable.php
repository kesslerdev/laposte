<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\Entries\AuthorizedDestinationEntry;
use Skimia\LaPoste\Params\ParamsTableBase;

class AuthorizedDestinationsTable extends ParamsTableBase
{

    public function canSend($productId, $startPostalCode, $endPostalCode){
        $product = $this->base->getProducts()->findById($productId);

        $authAreas = $this->findAuthorizedDestinationsForProduct($product->getProductCode());

        $startArea = $this->base->getAreas()->findByCP($startPostalCode);
        $endArea = $this->base->getAreas()->findByCP($endPostalCode);

        if(!isset($endArea)){
            die('erreur impossible denvoyer ce flux le plis utilise une zone non référencée pour le code postal:'.$endPostalCode);
        }

        if(!isset($startArea)){
            die('erreur impossible denvoyer ce flux l\'etablissement de prise en charge utilise une zone non référencée pour le code postal:'.$startPostalCode);
        }

        foreach ($authAreas as $znA) {
            if($znA->getStartAreaCode() == $startArea->getAreaCode() && $znA->getEndAreaCode() == $endArea->getAreaCode())
                return true;
        }

        return false;
    }


    /**
     * @param $productId
     * @return AuthorizedDestinationEntry[]
     */
    public function findAuthorizedDestinationsForProduct($productId){
        return $this->findManyBy($productId);
    }

    /**
     * @param $line
     * @return AuthorizedDestinationEntry
     */
    protected function createObjectLine($line)
    {
        return new AuthorizedDestinationEntry($line,$this->base);
    }
}