<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\Entries\AreaEntry;
use Skimia\LaPoste\Params\ParamsTableBase;

class AreasTable extends ParamsTableBase
{

    /**
     * @param $postalCode
     * @return AreaEntry
     */
    public function findByCP($postalCode){

        $postalCode = intval($postalCode);
        $elems = $this->all();
        foreach ($elems as $zone) {
            if($zone->getMinPostalCode() <= $postalCode && $zone->getMaxPostalCode() >= $postalCode )
                return $zone;
        }

    }

    public function isMainland($postalCode){
        $zone = $this->findByCP($postalCode);

        return $zone->getCode() == 1;
    }

    /**
     * @param $line
     * @return AreaEntry
     */
    protected function createObjectLine($line)
    {
        return new AreaEntry($line,$this->base);
    }

    /**
     * @param $areaId
     * @return AreaEntry
     */
    public function findById($areaId){
        return $this->findBy($areaId,2);
    }

    /**
     * @param $areaLabel
     * @return AreaEntry
     */
    public function findByLabel($areaLabel){
        return $this->findBy($areaLabel,3);
    }
}