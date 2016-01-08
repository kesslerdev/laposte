<?php

namespace Skimia\LaPoste\Containers;



use Skimia\LaPoste\Lists\ListInterface;
use Skimia\LaPoste\Params\ParamsDirectoryBase;
use Skimia\LaPoste\Params\ProductionSiteParams;

class Shipment
{
    const POSTAGE_METHOD_CE_MULTI = 1;
    const POSTAGE_METHOD_CE_MONO = 2;
    const POSTAGE_METHOD_MA = 3;
    const POSTAGE_METHOD_POST_PAID = 4;
    /**
     * @var ParamsDirectoryBase
     */
    protected $db_params;

    /**
     * @var mixed[]
     */
    protected $deposits;


    protected $mailDropInNumber = false;

    protected $postageMethod = self::POSTAGE_METHOD_MA;

    //region Gestion du type de depot en nombre ou égréné
    public function setMaildropInNumber(){
        $this->mailDropInNumber = true;
        foreach($this->deposits as $deposits_array){

            foreach ($deposits_array as $deposit) {
                $deposit->setMaildropInNumber();
            }
        }
    }

    public function setMaildropInGinned(){
        $this->mailDropInNumber = false;
        foreach($this->deposits as $deposits_array){

            foreach ($deposits_array as $deposit) {
                $deposit->setMaildropInGinned();
            }
        }
    }
    //endregion

    //region Gestion du type d'affranchissement
    public function setPostageMethodCEMono(){
        $this->postageMethod = self::POSTAGE_METHOD_CE_MONO;
        foreach($this->deposits as $deposits_array){

            foreach ($deposits_array as $deposit) {
                $deposit->setPostageMethodCEMono();
            }
        }
    }
    public function setPostageMethodCEMulti(){
        $this->postageMethod = self::POSTAGE_METHOD_CE_MULTI;
        foreach($this->deposits as $deposits_array){

            foreach ($deposits_array as $deposit) {
                $deposit->setPostageMethodCEMulti();
            }
        }
    }
    public function setPostageMethodMA(){
        $this->postageMethod = self::POSTAGE_METHOD_MA;
        foreach($this->deposits as $deposits_array){

            foreach ($deposits_array as $deposit) {
                $deposit->setPostageMethodMA();
            }
        }
    }
    public function setPostageMethodPostPaid(){
        $this->postageMethod = self::POSTAGE_METHOD_POST_PAID;
        foreach($this->deposits as $deposits_array){

            foreach ($deposits_array as $deposit) {
                $deposit->setPostageMethodPostPaid();
            }
        }
    }
    //endregion

    public function __construct(ParamsDirectoryBase $db){
        $this->db_params = $db;
        $this->deposits = [];
    }

    public function getDBParams(){
        return $this->db_params;
    }

    //region Ajout de depot par liste
    /**
     * @param ProductionSiteParams $params
     * @param $productCode
     * @param ListInterface $envelopes
     * @return Deposit
     */
    public function bindList(ProductionSiteParams $params, $productCode, ListInterface $envelopes){
        $deposit = new Deposit($this,$params,$productCode);
        $deposit->bindList($envelopes);

        if($this->mailDropInNumber)
            $deposit->setMaildropInNumber();
        else
            $deposit->setMaildropInGinned();

        $deposit->setPostageMethod($this->postageMethod);
        if(!isset($this->deposits[$productCode]))
            $this->deposits[$productCode] = [];

        $this->deposits[$productCode][] = $deposit;

        return $deposit;
    }

    public function bindCustomList(ListInterface $envelopes){
        $deposit = new Deposit($this);
        $deposit->bindList($envelopes);
        if($this->mailDropInNumber)
            $deposit->setMaildropInNumber();
        else
            $deposit->setMaildropInGinned();
        $deposit->setPostageMethod($this->postageMethod);
        if(!isset($this->deposits['KUST']))
            $this->deposits['KUST'] = [];
        $this->deposits['KUST'][] = $deposit;
    }
    //endregion

    protected $routine;
    public function setNewCodeRoutine(callable $event){
        $this->routine = $event;
    }

    public function getNewCode($productID,$envelope){
        if(!isset($this->routine))
            return false;

        $callable = $this->routine;
        return $callable($productID,$envelope);
    }
    
    public function getDeposits(){
        return $this->deposits;
    }

}