<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\Entries\ProcessingServiceEntry;
use Skimia\LaPoste\Params\ParamsTableBase;

class ProcessingServiceTable extends ParamsTableBase
{
    /**
     * @param $line
     * @return ProcessingServiceEntry
     */
    protected function createObjectLine($line)
    {
        return new ProcessingServiceEntry($line,$this->base);
    }
}