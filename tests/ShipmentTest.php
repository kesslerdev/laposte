<?php
use Skimia\LaPoste\Params\ParamsDirectoryBase;
class ShipmentTest extends TestCase
{

    protected $dirloader;
    protected $shipment;

    /**
     * @return ParamsDirectoryBase
     */
    protected function getDirLoader(){
        if(!isset($this->dirloader)){
            $dir = __DIR__.'/fixtures/post';
            $this->dirloader = new ParamsDirectoryBase($dir);
        }
        return $this->dirloader;
    }

    protected function getDeposits(){

        $this->shipment = new \Skimia\LaPoste\Containers\Shipment($this->getDirLoader());
        $this->shipment->setMaildropInGinned();
        $this->shipment->setNewCodeRoutine(function($productCode, $enveloppe){
            switch($productCode){
                case '75':
                    return '2KXXXXX56857';
                    break;
            }
        });
        $production = new \Skimia\LaPoste\Params\ProductionSiteParams(__DIR__.'/fixtures/conf/site1.php');

        $production->setContactor('special');

        $this->makeTestList($filename);
        $listLoader = new \Skimia\LaPoste\Lists\Loader\LaPosteTestListLoader($filename);

        return $this->shipment->bindList($production,'75',$listLoader);
    }
    public function testShipment(){


        /*var_dump(array_keys($deposit->getContainers()));
        die();*/

    }

    public function testPrinter(){
        $printer = new \Skimia\LaPoste\Printer\Printer();

        $deposit = $this->getDeposits();
        $printer->loadContainers($deposit->getContainers());

        $printer->write(__DIR__.'/../cache/containers.pdf');

        $printer2 = new \Skimia\LaPoste\Printer\Printer();

        $printer2->loadEnvelopes($deposit->getEnveloppes(),function($envelop){
            return '<strong>CUSTOM INFO</strong><br><strong>bla bla bla</strong>';
        });

        $printer2->write(__DIR__.'/../cache/envelopes.pdf');

    }

    public function makeTestList(&$fname = null){
        $fname = __DIR__.'/fixtures/lists/T_666_adresses.txt';
        $faker = Faker\Factory::create('fr_FR');

        $file = '';

        for($i = 0 ; $i < 10 ; $i++){
            $postcode = intval(str_replace(' ','',$faker->postcode));
            $file .= sprintf("%s %s;%s;;;;%s;%s;%s;%s;%s",
                $faker->firstName,
                $faker->lastName,
                $faker->streetAddress,
                    $postcode > 95999 ? 59999:$postcode,
                $faker->city,
                $faker->phoneNumber,
                $faker->email,
                    $faker->numberBetween(10,200)

            )."\n";
        }
        file_put_contents($fname,$file);
    }


}