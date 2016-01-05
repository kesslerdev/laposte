<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\Entries\ReportableFieldEntry;
use Skimia\LaPoste\Params\ParamsTableBase;

class ReportableFieldsTable extends ParamsTableBase
{
    /**
     * @param $line
     * @return ReportableFieldEntry
     */
    protected function createObjectLine($line)
    {
        return new ReportableFieldEntry($line,$this->base);
    }
}