<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\Entries\DepositOptionEntry;
use Skimia\LaPoste\Params\ParamsTableBase;

class DepositOptionsTable extends ParamsTableBase
{
    /**
     * @param $line
     * @return DepositOptionEntry
     */
    protected function createObjectLine($line)
    {
        return new DepositOptionEntry($line,$this->base);
    }
}