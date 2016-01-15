<?php
use Skimia\LaPoste\Params\ParamsDirectoryBase;
class DepositTest extends TestCase
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

    protected function getDeposit(){

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


        $this->makeTestList($filename);
        $listLoader = new \Skimia\LaPoste\Lists\Loader\LaPosteTestListLoader($filename);

        return $this->shipment->bindList($production,'75',$listLoader);
    }
    public function testShipment(){


        $printer = new \Skimia\LaPoste\Printer\DepositSlip();

        $deposit = $this->getDeposit();
        $deposit->setNumber(5555);
        $printer->loadDeposit($deposit);
        $printer->write(__DIR__.'/fixtures/slip/SLIP_WRITED.xls');
        //var_dump($deposit);
        die('FUCK');

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