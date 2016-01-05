<?php

namespace Skimia\LaPoste\Params;


class ParamsEntryBase
{
    protected $values;
    /**
     * @var ParamsDirectoryBase
     */
    protected $base;

    function __construct($arrayValues,$base){
        $this->values = $arrayValues;

        $this->base = $base;

    }

    protected function getColumns(){
        return [
            'x',
            'y'
        ];
    }

    public function get($col){
        $cols = $this->getColumns();

        $index = array_search($col,$cols);
        if($index !== false){
            return $this->values[$index];
        }
    }

    public function getValues(){
        return $this->values;
    }

}