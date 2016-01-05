<?php
use Skimia\LaPoste\Params\ParamsDirectoryBase;

class ParamsDirectoryTest extends TestCase
{
    protected $dirloader;

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

    public function testLoadingDatabase(){
        $dbDir = $this->getDirLoader();

        $this->assertTrue($dbDir->getVersion() == '8');
    }

    public function testProductTable(){

        $dbDir = $this->getDirLoader();
        $productTable = $dbDir->getProducts();
        $product = $productTable->findById(75);

        $this->assertEquals(75,$product->getProductCode());
        $this->assertEquals('SIGN LS',$product->getLabel());

        $product = $productTable->findById(100);

        $this->assertEquals(100,$product->getProductCode());
        $this->assertEquals('VALEUR DECLAREE',$product->getLongLabel());
        $this->assertFalse($product->hasVAT());

        $this->assertInstanceOf('\Skimia\LaPoste\Params\Entries\ProductEntry',$productTable->findById(75));
        $destinations = $dbDir->getAuthorizedDestinations()->findAuthorizedDestinationsForProduct(75);

        $this->assertInstanceOf('\Skimia\LaPoste\Params\Entries\AuthorizedDestinationEntry',current($destinations));
    }
}