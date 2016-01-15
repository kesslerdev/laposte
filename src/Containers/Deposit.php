<?php

namespace Skimia\LaPoste\Containers;



use Skimia\LaPoste\Lists\EnvelopeInterface;
use Skimia\LaPoste\Lists\ListInterface;
use Skimia\LaPoste\Params\ParamsDirectoryBase;
use Skimia\LaPoste\Params\ProductionSiteParams;

class Deposit
{
    //region Propriétées
    protected $parent;

    protected $mailDropInNumber;

    protected $postageMethod = Shipment::POSTAGE_METHOD_MA;

    /**
     * @var bool|\Skimia\LaPoste\Params\Entries\ProductEntry
     */
    protected $commercialProduct;

    protected $productionParams;

    protected $number;

    /**
     * @var ListInterface
     */
    protected $envelopes;

    protected $containers;
    //endregion

    //region Initialisation du depot
    public function __construct(Shipment $parent, ProductionSiteParams $productionParams = null,$product = false){
        $this->parent = $parent;
        $this->productionParams = $productionParams;
        $this->commercialProduct = $product != null ? $this->parent->getDBParams()->getProducts()->findById($product) : false ;

    }

    public function bindList(ListInterface $envelopes){
        $this->envelopes = $envelopes;

        if(!$this->isCustomProduct()){
            $this->checkValidSlice();
            $this->checkAuthorizedDestinations();
        }

        $envelopes = $this->envelopes->getEnvelopes();
        foreach ( $envelopes as &$envelope) {
            if(!$envelope->hasTrackingNumber())
                $envelope->setTrackingNumber($this->getNewCode($this->isCustomProduct() ? '0' : $this->commercialProduct->getProductCode(),$envelope));
        }

    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return str_pad($this->number,6,'0',STR_PAD_LEFT);
    }
    //endregion


    public function setNumber($number){
        $this->number = $number;
    }

    public function isCustomProduct(){
        return $this->commercialProduct == false;
    }

    /**
     * @return Shipment
     */
    public function getShipment(){
        return $this->parent;
    }

    /**
     * @return ProductionSiteParams
     */
    public function getSiteParams(){
        return $this->productionParams;
    }

    /**
     * @return bool|\Skimia\LaPoste\Params\Entries\ProductEntry
     */
    public function getProduct(){
        return $this->commercialProduct;
    }

    //region Séléction mode d'envoi égréné ou en nombre
    public function setMaildropInNumber(){
        $this->mailDropInNumber = true;
        die('les depots en nombre ne sont pas encore gérées');
    }

    public function setMaildropInGinned(){
        $this->mailDropInNumber = false;
    }
    //endregion

    //region Selection du type d'affranchissement
    public function setPostageMethodCEMono(){
        $this->postageMethod = Shipment::POSTAGE_METHOD_CE_MONO;
    }
    public function setPostageMethodCEMulti(){
        $this->postageMethod = Shipment::POSTAGE_METHOD_CE_MULTI;
    }
    public function setPostageMethodMA(){
        $this->postageMethod = Shipment::POSTAGE_METHOD_MA;
    }
    public function setPostageMethodPostPaid(){
        $this->postageMethod = Shipment::POSTAGE_METHOD_POST_PAID;
    }

    public function setPostageMethod($method){
        $this->postageMethod = $method;
    }

    public function getPostageMethod(){
        return $this->postageMethod;
    }
    //endregion

    //region Checks Bon produit et bonnes destinations
    protected function checkValidSlice(){
        if($this->isCustomProduct())
            return true;

        if($this->commercialProduct->getMinUse() > $this->envelopes->count())
            die('erreur impossible denvoyer ce flux le nombre de plis est inférieur au nombre de prix minimal pour utilise se produit LAPoste');
    }

    protected function checkAuthorizedDestinations(){
        if($this->isCustomProduct())
            return true;

        $authDest = $this->parent->getDBParams()->getAuthorizedDestinations();
        foreach ($this->envelopes->getEnvelopes() as $envelope) {
            $destCode = $envelope->getPostalCode();
            $localCode = $this->productionParams->getEstablishment()->getPostalCode();
            $product = $this->commercialProduct->getProductCode();

            if(!$authDest->canSend($product,$localCode,$destCode))
                die('erreur impossible denvoyer ce flux un plis ne peut être envoyé à sa destination sous ce produit code postal: '.$destCode);

        }
        if($this->commercialProduct->getMinUse() > $this->envelopes->count())
            die('erreur impossible denvoyer ce flux le nombre de plis est inférieur au nombre de prix minimal pour utilise se produit LAPoste');
    }
    //endregion

    public function makeContainers(){
        $this->containers = [];

        if($this->isCustomProduct()){
            return;
        }
        if($this->mailDropInNumber){}
        else{//egrene

            switch($this->postageMethod){
                case Shipment::POSTAGE_METHOD_MA:
                    //REGROUPEMENT TOUTEFRANCE

                    $this->makeGinnedMAContainers();

                    break;
                default:
                    throw new \Exception('ce mode d\'affranchissement n\'est pas encore géré');
                    break;
            }


        }
    }

    protected function makeGinnedMAContainers(){
        foreach ($this->envelopes->getEnvelopes() as $envelope) {
            $this->addToTouteFranceContainer($envelope);
        }
    }
    protected function makeTouteFranceContainer(){
        $container = new Container($this);
        $container->setRegrouping(Container::REGROUP_ALL_FRANCE);
        $container->title = 'Toute France';
        $container->product = $this->commercialProduct->getLabel();
        $container->apch = $this->productionParams->getEstablishment()->getS3CCode();
        return $container;
    }

    public function addToTouteFranceContainer(EnvelopeInterface $envelope){
        if(!isset($this->containers['ttfr'])){
            $this->containers['ttfr'] = $this->makeTouteFranceContainer();
        }

        $this->containers['ttfr']->addEnvelope($envelope);
    }


    public function getContainers(){
        if(!isset( $this->containers))
            $this->makeContainers();
        return $this->containers;
    }

    public function getEnveloppes(){

        return $this->envelopes;
    }

    public function getNewCode($productID,$envelope){
        return $this->parent->getNewCode($productID,$envelope);
    }
}