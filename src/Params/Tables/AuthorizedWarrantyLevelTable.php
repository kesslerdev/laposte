<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 08/12/2015
 * Time: 09:46
 */

namespace Skimia\LaPoste\Params\Tables;


use Skimia\LaPoste\Params\Entries\AuthorizedWarrantyLevelEntry;
use Skimia\LaPoste\Params\ParamsTableBase;

class AuthorizedWarrantyLevelTable extends ParamsTableBase
{
    /**
     * @param $line
     * @return AuthorizedWarrantyLevelEntry
     */
    protected function createObjectLine($line)
    {
        return new AuthorizedWarrantyLevelEntry($line,$this->base);
    }
}