<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\Entries\SliceEntry;
use Skimia\LaPoste\Params\ParamsTableBase;

class SlicesTable extends ParamsTableBase
{

    /**
     * @param $line
     * @return SliceEntry
     */
    protected function createObjectLine($line)
    {
        return new SliceEntry($line,$this->base);
    }
}