<?php
use Skimia\LaPoste\Params\ParamsDirectoryBase;

class ParamsProductionTest extends TestCase
{

    public function testProductionParams(){
        $production = new \Skimia\LaPoste\Params\ProductionSiteParams(__DIR__.'/fixtures/conf/site1.php');

        $this->assertEquals('depositor_coclico',$production->getDepositor()->getCOCLICO());
        $this->assertEquals('european_CE_identifier',$production->getContractor()->getEuropeanIdentifier());
        $this->assertEquals('default_contractor_corp_name',$production->getContractor()->getCorpName());
        $this->assertEquals('billing_coclico_default_contractor',$production->getContractor()->getBilling()->getCOCLICO());
        $this->assertEquals('special_contractor_corp_name',$production->getContractor('special')->getCorpName());
        //si aucun contact billing utiliser le contractor
        $this->assertEquals('special_COCLICO',$production->getContractor('special')->getBilling()->getCOCLICO());


        $this->assertEquals('S3C',$production->getEstablishment()->getS3CCode());
    }


}