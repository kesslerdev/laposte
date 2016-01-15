<?php

namespace Skimia\LaPoste\Printer;


use Skimia\LaPoste\Containers\Container;
use Philo\Blade\Blade;
use Skimia\LaPoste\Containers\Deposit;
use Skimia\LaPoste\Containers\Shipment;
use Skimia\LaPoste\Lists\ListInterface;

class DepositSlipXml
{
    protected $deposit = null;

    public function __construct(){

    }

    public function loadDeposit(Deposit $deposit){
        $vars = [];

        $vars['wtVersion'] = $deposit->getShipment()->getDBParams()->getVersion();

        $vars['afMode'] = ($deposit->getPostageMethod() == Shipment::POSTAGE_METHOD_MA ? 'MA':($deposit->getPostageMethod() == Shipment::POSTAGE_METHOD_POST_PAID ? 'PP':($deposit->getPostageMethod() == Shipment::POSTAGE_METHOD_CE_MONO || $deposit->getPostageMethod() == Shipment::POSTAGE_METHOD_CE_MULTI ? 'CE':'CE')));
        $vars['deposeNumber'] = $deposit->getNumber();
        $vars['coclicoFacturation'] = $deposit->getSiteParams()->getContractor()->getBilling()->getCOCLICO();
        $vars['coclicoContactant'] = $deposit->getSiteParams()->getContractor()->getCOCLICO();
        $vars['coclicoDeposant'] = $deposit->getSiteParams()->getDepositor()->getCOCLICO();


        $today = date("d/m/Y");
        $vars['depositLabel'] = 'DEPOT '.$deposit->getSiteParams()->getContractor()->getCorpName().' du '.$today;
        $vars['depositSite'] = $deposit->getSiteParams()->getEstablishment()->getS3CCode();
        $vars['prodCom'] = $deposit->getProduct()->getProductCode();
        $vars['noMachine'] = $deposit->getSiteParams()->getMANumber();
        $vars['noCtrProduct'] = $deposit->getSiteParams()->getContractor()->getPostageContractNumber();
        $vars['coclicoEmeteur'] = $deposit->getSiteParams()->getContractor()->getCOCLICO();


        $vars['codeProd'] = '2L';
        $vars['suivAccount'] = $deposit->getSiteParams()->getContractor()->getPostageAccountNumber();
        $vars['socName'] = $deposit->getSiteParams()->getContractor()->getCorpName();
        $vars['socAdd'] = $deposit->getSiteParams()->getContractor()->getAddress();
        $vars['socCP'] = $deposit->getSiteParams()->getContractor()->getPostalCode();
        $vars['socCity'] = $deposit->getSiteParams()->getContractor()->getCity();
        $vars['socTel'] = $deposit->getSiteParams()->getContractor()->getPhone();
        $vars['socMail'] = $deposit->getSiteParams()->getContractor()->getMail();
        $vars['envelops'] = $deposit->getEnveloppes()->getEnvelopes();

        $blade = $this->getBlade();
        return $blade->view()->make('webserviceslip',$vars);
    }

    /**
     * @return Blade
     */
    protected function getBlade(){
        if(!isset($this->blade)){
            $views = __DIR__ . '/../../views';
            if(function_exists('storage_path'))
                $cache = storage_path() .'/cache';
            else
                $cache = __DIR__ . '/../../cache';

            if(!file_exists($cache))
                mkdir($cache,0777,true);

            $this->blade = new Blade($views, $cache);
        }
        return $this->blade;
    }

    protected function getKey(Deposit $deposit){
        return sprintf('%s;%s;%s%s',
            $deposit->getSiteParams()->getEstablishment()->getS3CCode(),
            $deposit->getSiteParams()->getContractor()->getBilling()->getCOCLICO(),
            date("Y"),
            str_pad($deposit->getNumber(),6,'0',STR_PAD_LEFT));
    }


}