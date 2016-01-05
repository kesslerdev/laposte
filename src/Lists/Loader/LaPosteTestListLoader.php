<?php

namespace Skimia\LaPoste\Lists\Loader;



use Skimia\LaPoste\Lists\ListInterface;

class LaPosteTestListLoader implements ListInterface
{
    protected $file;
    protected $envelopes;

    public function __construct($file)
    {
        $this->file = $file;
        $this->loadFile();
    }

    public function count()
    {
        return count($this->envelopes);
    }

    protected function loadFile(){
        $handle = fopen( $this->file, "r");
        while (($line = fgets($handle)) !== false) {
            $line_parts = explode(";",$line);
            $this->envelopes[] = new LaPosteTestEnvelope($line_parts);
        }
        fclose($handle);
    }

    public function getEnvelopes()
    {
        return $this->envelopes;
    }
}