<?php

namespace Skimia\LaPoste\Params;

use Skimia\LaPoste\Params\Production\ProductionSiteContractor;
use Skimia\LaPoste\Params\Production\ProductionSiteEstablishment;
use Skimia\LaPoste\Params\Production\ProductionSiteWorker;
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


class ProductionSiteParams
{


    use FilesTrait;

    protected $file = false;

    protected $data = false;

    protected $current_contractor = false;

    public function __construct($file)
    {
        $this->file = $file;

        $this->loadData();
    }

    protected function loadData(){
        $this->data = require($this->file);
    }

    /**
     * @return ProductionSiteEstablishment
     */
    public function getEstablishment(){

        return new ProductionSiteEstablishment($this->data['establishment']);
    }

    /**
     * @return ProductionSiteWorker
     */
    public function getDepositor(){
        return new ProductionSiteWorker($this->data['depositor']);
    }

    /**
     * @return ProductionSiteContractor[]
     */
    public function getContractors(){
        $contractors = [];
        foreach ($this->data['contractors'] as $name=>$contractor) {
            $contractors[$name] = new ProductionSiteContractor($contractor);
        }
        return $contractors;
    }

    /**
     * @param null $name nom du contractor
     * @return ProductionSiteContractor
     */
    public function getContractor($name = null){
        //PHP 7 line => $default = $name ?? $this->data['default_contractor'];
        $default = isset($name)? $name : ($this->current_contractor? $this->current_contractor : $this->data['default_contractor']);
        return new ProductionSiteContractor($this->data['contractors'][$default]);
    }

    public function setContactor($name){
        $this->current_contractor = $name;
    }

    public function getMANumber(){
        return $this->data['MA_number'];
    }
}