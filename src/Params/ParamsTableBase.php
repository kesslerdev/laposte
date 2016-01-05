<?php
/**
 * Created by PhpStorm.
 * User: gsm
 * Date: 07/12/2015
 * Time: 12:51
 */

namespace Skimia\LaPoste\Params;


use Skimia\LaPoste\Support\Collection;

class ParamsTableBase extends Collection
{
    protected $tableFile;
    /**
     * @var ParamsDirectoryBase
     */
    protected $base;

    function __construct($tableFile,ParamsDirectoryBase $base){

        parent::__construct();

        $this->tableFile = $tableFile;

        $this->base = $base;

        $this->loadTable();
    }

    protected function loadTable(){
        $i = 0;
        foreach(file($this->tableFile) as $line) {
            if($i !== 0){
                $parts = explode(';',trim($line));

                $this->push($this->createObjectLine($parts));
            }


            $i++;
            // loop with $line for each line of yourfile.txt
        }
    }

    public function findBy($key ,$keyIndex = 0){
        foreach ($this->toArray() as $item) {
            if($item->getValues()[$keyIndex] == $key)
                return $item;
        }

    }

    public function findManyBy($key ,$keyIndex = 0){
        $items = [];

        foreach ($this->items as $item) {
            if($item->getValues()[$keyIndex] == $key)
                $items[] = $item;
        }

        return $items;

    }

    public function toSingleArray()
    {
        return array_map(function($value)
        {
            return $value;

        }, $this->items);
    }

    protected function createObjectLine($line){
        return $line;
    }

}