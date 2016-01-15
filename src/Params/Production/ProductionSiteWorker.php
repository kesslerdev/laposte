<?php

namespace Skimia\LaPoste\Params\Production;

use Skimia\LaPoste\Params\Tables\AreasTable;
use Skimia\LaPoste\Params\Tables\AuthorizedDestinationsTable;
use Skimia\LaPoste\Params\Tables\AuthorizedWarrantyLevelTable;
use Skimia\LaPoste\Params\Tables\CombinationsTable;
use Skimia\LaPoste\Params\Tables\DepositOptionsTable;
use Skimia\LaPoste\Params\Tables\OvertaxedAreasTable;
use Skimia\LaPoste\Params\Tables\ProcessingServiceTable;
use Skimia\LaPoste\Params\Tables\ProductsTable;
use Skimia\LaPoste\Params\Tables\ReportableFieldsTable;
use Skimia\LaPoste\Params\Tables\SlicesTable;
use Skimia\LaPoste\Params\Tables\TrackingStateTable;
use Skimia\LaPoste\Params\Tables\VATAreasTable;
use Skimia\LaPoste\Traits\FilesTrait;


class ProductionSiteWorker
{

    protected $data;

    protected $coclico = false;

    protected $name = false;

    protected $phone_number = false;
    protected $address = false;

    public function __construct(array $arr)
    {
        $this->coclico = $arr['COCLICO'];
        $this->name = $arr['corp_name'];
        $this->phone_number = $arr['phone'];

        if(isset($arr['address']))
            $this->address = $arr['address'];
        else
            $this->address = [
                'address'=>'',
                'postal_code'=>'',
                'city'=>'',
                'mail'=>''
            ];

        $this->data = $arr;

    }

    public function getCorpName(){
        return $this->name;
    }

    public function getCOCLICO(){
        return $this->coclico;
    }

    public function getPhone(){
        return $this->phone_number;
    }

    public function getAddress(){
        return $this->address['address'];
    }

    public function getPostalCode(){
        return $this->address['postal_code'];
    }

    public function getCity(){
        return $this->address['city'];
    }

    public function getMail(){
        return $this->address['mail'];
    }

}