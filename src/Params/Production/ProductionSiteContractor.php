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


class ProductionSiteContractor extends ProductionSiteWorker
{

    protected $european_identifier = false;

    protected $postage_contract_number = false;
    protected $postage_account_number = false;

    public function __construct(array $arr)
    {
        parent::__construct($arr);

        $this->european_identifier = $arr['european_identifier'];
        $this->postage_contract_number = $arr['postage_contract_number'];
        $this->postage_account_number = $arr['postage_account_number'];

    }


    public function getEuropeanIdentifier(){
        return $this->european_identifier;
    }

    public function getPostageContractNumber(){
        return $this->postage_contract_number;
    }

    public function getPostageAccountNumber(){
        return $this->postage_account_number;
    }



    /**
     * @return ProductionSiteWorker
     */
    public function getBilling(){
        if(!isset($this->data['billing']))
            return $this;
        return new ProductionSiteWorker($this->data['billing']);
    }
}