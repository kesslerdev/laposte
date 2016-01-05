<?php

namespace Skimia\LaPoste\Lists\Loader;



use Skimia\LaPoste\Lists\EnvelopeInterface;

class LaPosteTestEnvelope implements EnvelopeInterface
{
    protected $parts;
    protected $trackingNumber;


    public function __construct(array $arr)
    {
        $this->parts = $arr;
    }

    public function getName()
    {
        return $this->parts[0];
    }

    public function getAddress()
    {
        return $this->parts[1].
        (!empty($this->parts[2]) ?"\n".$this->parts[2]:'').
        (!empty($this->parts[3]) ?"\n".$this->parts[3]:'').
        (!empty($this->parts[4]) ?"\n".$this->parts[4]:'');
    }

    public function getPostalCode()
    {
        return str_replace(' ','',$this->parts[5]);
    }

    public function getCity()
    {
        return $this->parts[6];
    }

    public function setTrackingNumber($tracking)
    {
        $this->trackingNumber = $tracking;
    }

    public function getPhone()
    {
        return $this->parts[7];
    }

    public function getTrackingNumber()
    {
        return $this->trackingNumber ? $this->trackingNumber : false;
    }

    public function getFullAddress()
    {
        return $this->getName()."\n".$this->getAddress()."\n".$this->getPostalCode()." - ".$this->getCity();
    }

    public function getMail()
    {
        return $this->parts[8];
    }

    public function getWeight()
    {
        return $this->parts[9];
    }

    public function getCustomInfo()
    {
        return '<h3>No Custom info</h3>';
    }

    public function getCustomLine($full = false)
    {
        return '<h3>No Custom line</h3>';
    }


}