<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\Entries\OvertaxedAreaEntry;
use Skimia\LaPoste\Params\ParamsTableBase;

class OvertaxedAreasTable extends ParamsTableBase
{
    /**
     * @param $line
     * @return OvertaxedAreaEntry
     */
    protected function createObjectLine($line)
    {
        return new OvertaxedAreaEntry($line,$this->base);
    }
}