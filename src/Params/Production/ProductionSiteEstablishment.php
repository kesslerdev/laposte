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


class ProductionSiteEstablishment
{

    protected $data;

    protected $codeS3C = false;

    protected $label = false;

    protected $postage_label = false;

    protected $postal_code = false;

    public function __construct(array $arr)
    {

        $this->codeS3C = $arr['code'];
        $this->label = $arr['label'];
        $this->postage_label = $arr['postage_label'];
        $this->postal_code = $arr['postal_code'];

        $this->data = $arr;

    }

    public function getS3CCode(){
        return $this->codeS3C;
    }

    public function getLabel(){
        return $this->label;
    }

    public function getPostageLabel(){
        return $this->postage_label;
    }

    public function getPostalCode(){
        return $this->postal_code;
    }
}