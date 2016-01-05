<?php

namespace Skimia\LaPoste\Lists;

interface EnvelopeInterface
{

    public function getFullAddress();

    public function getName();
    public function getAddress();
    public function getPostalCode();
    public function getCity();
    public function getPhone();
    public function getMail();
    public function getWeight();

    public function setTrackingNumber($tracking);
    public function getTrackingNumber();
    public function hasTrackingNumber();
    
    public function getCustomInfo();

    public function getCustomLine($full = false);
}