<?php

namespace Skimia\LaPoste\Printer;


use Skimia\LaPoste\Containers\Container;
use Philo\Blade\Blade;
use Skimia\LaPoste\Containers\Deposit;
use Skimia\LaPoste\Containers\Shipment;
use Skimia\LaPoste\Lists\ListInterface;

class DepositSlip
{
    protected $deposit = null;
    protected $xlsFile = null;
    protected $objExcel = null;
    protected $fileType = 'Excel5';

    public function __construct($file = false){

        if($file)
            $this->xlsFile = $file;
        else
            $this->xlsFile = __DIR__.'/../../tests/fixtures/slip/SLIP.xls';

        $objReader = \PHPExcel_IOFactory::createReader($this->fileType);

        $this->objExcel = $objReader->load($this->xlsFile);
    }

    public function loadDeposit(Deposit $deposit){
        $this->deposit = $deposit;

        $this->modifySheet('CONTACTOR_NAME',$deposit->getSiteParams()->getContractor()->getCorpName());
        $this->modifySheet('CONTACTOR_COCLICO',$deposit->getSiteParams()->getContractor()->getCOCLICO());
        $this->modifySheet('CONTACTOR_CONTRACT',$deposit->getSiteParams()->getContractor()->getPostageContractNumber());
        $this->modifySheet('CONTACTOR_ACCOUNT',$deposit->getSiteParams()->getContractor()->getPostageAccountNumber());
        $this->modifySheet('CONTACTOR_PHONE',$deposit->getSiteParams()->getContractor()->getPhone());
        $this->modifySheet('CONTACTOR_ADDRESS',$deposit->getSiteParams()->getContractor()->getAddress());
        $this->modifySheet('CONTACTOR_CP',$deposit->getSiteParams()->getContractor()->getPostalCode());
        $this->modifySheet('CONTACTOR_CITY',$deposit->getSiteParams()->getContractor()->getCity());
        $this->modifySheet('CONTACTOR_MAIL',$deposit->getSiteParams()->getContractor()->getMail());

        if($deposit->getSiteParams()->getContractor()->getBilling()->getCOCLICO() != $deposit->getSiteParams()->getContractor()->getCOCLICO())
            $this->modifySheet('CONTACTOR_BILL_COCLICO',$deposit->getSiteParams()->getContractor()->getBilling()->getCOCLICO());

        $this->modifySheet('DEPOSITOR_NAME',$deposit->getSiteParams()->getDepositor()->getCorpName());
        $this->modifySheet('DEPOSITOR_COCLICO',$deposit->getSiteParams()->getDepositor()->getCOCLICO());
        $this->modifySheet('DEPOSITOR_PHONE',$deposit->getSiteParams()->getDepositor()->getPhone());
        $this->modifySheet('DEPOSITOR_ADDRESS',$deposit->getSiteParams()->getDepositor()->getAddress());
        $this->modifySheet('DEPOSITOR_CP',$deposit->getSiteParams()->getDepositor()->getPostalCode());
        $this->modifySheet('DEPOSITOR_CITY',$deposit->getSiteParams()->getDepositor()->getCity());



        $this->modifySheet('ETABLISHMENT_LABEL',$deposit->getSiteParams()->getEstablishment()->getLabel());
        $this->modifySheet('ETABLISHMENT_CODE',$deposit->getSiteParams()->getEstablishment()->getS3CCode());

        $today = date("d/m/Y");
        $this->modifySheet('DEPOSIT_DATE',$today);
        $this->modifySheet('DEPOSIT_TIME',date('H:i'));
        $this->modifySheet('DEPOSIT_NUMBER',$deposit->getNumber());
        $this->modifySheet('DEPOSIT_LABEL','DEPOT '.$deposit->getSiteParams()->getContractor()->getCorpName().' du '.$today);

        if($deposit->getPostageMethod() == Shipment::POSTAGE_METHOD_MA){
            $this->modifySheet('DEPOSIT_MODE_MA','X');
            $this->modifySheet('DEPOSIT_MA_NUMBER',$deposit->getSiteParams()->getMANumber());

        }

        $product = $deposit->getProduct();

        if($product !== false)
            switch($product->getProductCode()){
                case '75':
                    $this->modifySheet('PRODUCT_SUIVI','X');
                    break;
            }


        $this->modifySheet('ENVELOPS_NUMBER',$deposit->getEnveloppes()->count());
        $path = $this->writeDatamatrix($deposit);

    }

    public function write($path){

        $objWriter = \PHPExcel_IOFactory::createWriter($this->objExcel,$this->fileType);

        if(file_exists($path))
            unlink($path);

        $objWriter->save($path);
    }


    protected function getKey(Deposit $deposit){
        return sprintf('%s;%s;%s%s',
            $deposit->getSiteParams()->getEstablishment()->getS3CCode(),
            $deposit->getSiteParams()->getContractor()->getBilling()->getCOCLICO(),
            date("Y"),
            str_pad($deposit->getNumber(),6,'0',STR_PAD_LEFT));
    }

    protected function writeDatamatrix(Deposit $deposit, $path = null){
        if(!$path){
            $path = dirname($this->xlsFile).'/'.$deposit->getNumber().'.png';
        }

        $key = $this->getKey($deposit);

        if(!function_exists('getDataMatrix'))
            require_once __DIR__.'/Barcode.php';

        $im=getDataMatrix($key);
        $objDrawing = new \PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('DATAMATRIX');
        $objDrawing->setDescription('POST DATAMATRIX');
        $objDrawing->setImageResource($im);
        $objDrawing->setRenderingFunction(\PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
        $objDrawing->setMimeType(\PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG);
        $objDrawing->setWorksheet($this->objExcel->getActiveSheet());

        $objDrawing->setCoordinates('BE18');
        $objDrawing->setHeight(140);
        $objDrawing->setWidth(140);
        $objDrawing->setResizeProportional(100);
        return $path;
    }



    public function modifySheet($key,$value,$sheetIndex = 0){

        $sheet = $this->objExcel->setActiveSheetIndex($sheetIndex);

        $cells = $this->mapCell($key);

        foreach ($cells as $cell) {
            $sheet->setCellValue($cell,$value);
        }

    }

    public function mapCell($index){
        $cells = [];
        switch($index){

            case 'CONTACTOR_NAME':
                $cells[] = 'C12';
                break;

            case 'CONTACTOR_COCLICO':
                $cells[] = 'C18';
                break;
            case 'CONTACTOR_BILL_COCLICO':
                $cells[] = 'Q18';
                break;
            case 'CONTACTOR_ACCOUNT':
                $cells[] = 'C16';
                break;
            case 'CONTACTOR_CONTRACT':
                $cells[] = 'O16';
                break;
            case 'CONTACTOR_PHONE':
                $cells[] = 'C14';
                break;
            case 'CONTACTOR_ADDRESS':
                $cells[] = 'AB12';
                break;
            case 'CONTACTOR_CP':
                $cells[] = 'AD15';
                break;
            case 'CONTACTOR_CITY':
                $cells[] = 'AM15';
                break;
            case 'CONTACTOR_MAIL':
                $cells[] = 'L14';
                break;




            case 'DEPOSITOR_NAME':
                $cells[] = 'C28';
                break;
            case 'DEPOSITOR_COCLICO':
                $cells[] = 'C31';
                break;

            case 'DEPOSITOR_PHONE':
                $cells[] = 'Q31';
                break;
            case 'DEPOSITOR_ADDRESS':
                $cells[] = 'AB28';
                break;
            case 'DEPOSITOR_CP':
                $cells[] = 'AD31';
                break;
            case 'DEPOSITOR_CITY':
                $cells[] = 'AM31';
                break;

            case 'ETABLISHMENT_LABEL':
                $cells[] = 'C36';
                break;
            case 'ETABLISHMENT_CODE':
                $cells[] = 'W36';
                break;

            case 'DEPOSIT_DATE':
                $cells[] = 'AE36';
                break;
            case 'DEPOSIT_TIME':
                $cells[] = 'AM36';
                break;
            case 'DEPOSIT_NUMBER':
                $cells[] = 'AT36';
                break;
            case 'DEPOSIT_LABEL':
                $cells[] = 'BD36';
                break;

            case 'DEPOSIT_MODE_MA':
                $cells[] = 'BC42';
                break;

            case 'DEPOSIT_MA_NUMBER':
                $cells[] = 'BJ42';
                break;


            case 'PRODUCT_SUIVI':
                $cells[] = 'C49';
                break;

            case 'ENVELOPS_NUMBER':
                $cells[] = 'AO108';
                break;

        }

        return $cells;
    }
}