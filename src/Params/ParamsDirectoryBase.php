<?php

namespace Skimia\LaPoste\Params;

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


class ParamsDirectoryBase
{

    const REGEXDataBaseDirCheck =  "/^parametresWTEnEg_([0-9]+)$/i";
    const REGEXDataTableFileCheck =  "/^([a-z_]+)_([0-9]+).txt$/i";

    use FilesTrait;

    protected $dir = false;
    protected $dataBaseDir = false;
    protected $tables = [];

    protected $version = false;

    public function __construct($dir)
    {
        $this->dir = $dir;

        $this->loadDir();
        $this->registerTables();

    }

    protected function loadDir(){
        $dataDirs = $this->directories($this->dir);

        foreach ($dataDirs as $dir) {
            $spl = new \SplFileInfo($dir);

            if(preg_match(self::REGEXDataBaseDirCheck, $spl->getFilename(), $matches)){
                $this->dataBaseDir = $spl->getPathName();
                $this->version = end($matches);
                break;
            }


        }
    }

    protected function registerTables(){
        $dataTables = $this->allFiles($this->dataBaseDir);

        foreach ($dataTables as $file) {
            $spl = new \SplFileInfo($file);
            if(preg_match(self::REGEXDataTableFileCheck, $spl->getFilename(), $matches)){
                if(count($matches) != 3  || $matches[2] != $this->version)
                    continue;
                $this->tables[$matches[1]] = $spl->getPathName();//NON init
            }
        }

        return $this;

    }


    public function getVersion(){
        return $this->version;
    }

    protected function loadTable($name){
        if(isset($this->tables[$name])){

            switch($name){
                case 'param_produits':
                    return new ProductsTable($this->tables[$name],$this);
                    break;
                case 'niveau_garantie_autorise':
                    return new AuthorizedWarrantyLevelTable($this->tables[$name],$this);
                    break;
                case 'param_champs_declarables':
                    return new ReportableFieldsTable($this->tables[$name],$this);
                    break;
                case 'param_zones':
                    return new AreasTable($this->tables[$name],$this);
                    break;
                case 'param_destinations_autorisees':
                    return new AuthorizedDestinationsTable($this->tables[$name],$this);
                    break;
                case 'param_combinaisons':
                    return new CombinationsTable($this->tables[$name],$this);
                    break;
                case 'param_options_t_depot':
                    return new DepositOptionsTable($this->tables[$name],$this);
                    break;
                case 'param_zones_surtaxes':
                    return new OvertaxedAreasTable($this->tables[$name],$this);
                    break;
                case 'param_traitements_services':
                    return new ProcessingServiceTable($this->tables[$name],$this);
                    break;
                case 'param_tranches':
                    return new SlicesTable($this->tables[$name],$this);
                    break;
                case 'param_statuts_suivi':
                    return new TrackingStateTable($this->tables[$name],$this);
                    break;
                case 'param_zones_tva':
                    return new VATAreasTable($this->tables[$name],$this);
                    break;

                default:
                    return new ParamsTableBase($this->tables[$name],$this);
                    break;
            }



        }

        die('error');
    }

    protected function getTable($name){

        if(isset($this->tables[$name])){

            if(!is_object($this->tables[$name]))
                return $this->tables[$name] = $this->loadTable($name);
            else
                return $this->tables[$name];

        }

        die('error');
    }

    public function table($name){
        return $this->getTable($name);
    }

    /**
     * @return ProductsTable
     */
    public function getProducts(){
        return $this->table('param_produits');
    }

    /**
     * @return AuthorizedWarrantyLevelTable
     */
    public function getAuthorizedWarrantyLevel(){
        return $this->table('niveau_garantie_autorise');
    }

    /**
     * @return ReportableFieldsTable
     */
    public function getReportableFields(){
        return $this->table('param_champs_declarables');
    }
    /**
     * @return AreasTable
     */
    public function getAreas(){
        return $this->table('param_zones');
    }
    /**
     * @return AuthorizedDestinationsTable
     */
    public function getAuthorizedDestinations(){
        return $this->table('param_destinations_autorisees');
    }
    /**
     * @return CombinationsTable
     */
    public function getCombinations(){
        return $this->table('param_combinaisons');
    }
    /**
     * @return DepositOptionsTable
     */
    public function getDepositOptions(){
        return $this->table('param_options_t_depot');
    }
    /**
     * @return OvertaxedAreasTable
     */
    public function getOvertaxedAreas(){
        return $this->table('param_zones_surtaxes');
    }
    /**
     * @return ProcessingServiceTable
     */
    public function getProcessingService(){
        return $this->table('param_traitements_services');
    }
    /**
     * @return SlicesTable
     */
    public function getSlices(){
        return $this->table('param_tranches');
    }
    /**
     * @return TrackingStateTable
     */
    public function getTrackingState(){
        return $this->table('param_statuts_suivi');
    }
    /**
     * @return VATAreasTable
     */
    public function getVATAreas(){
        return $this->table('param_zones_tva');
    }
}