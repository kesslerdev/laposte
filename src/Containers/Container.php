<?php

namespace Skimia\LaPoste\Containers;



use Skimia\LaPoste\Lists\EnvelopeInterface;

class Container
{
    const REGROUP_INTRA_DEPARTMENTS = 1;
    const REGROUP_AREA_DEPARTURE_ARRIVAL = 2;
    const REGROUP_ALL_FRANCE = 3;
    const REGROUP_SLICES_WEIGHT = 4;
    const REGROUP_MONO_WEIGHT = 5;

    protected $parent;
    protected $regrouping;

    public $title;
    public $product;
    public $apch;

    /**
     * @var EnvelopeInterface[]
     */
    protected $envelopes;

    public function __construct(Deposit $parent){
        $this->parent = $parent;

        $this->envelopes = [];

    }

    public function setRegrouping($regrouping){
        $this->regrouping = $regrouping;
    }

    public function addEnvelope(EnvelopeInterface $envelope){
        $this->envelopes[] = $envelope;
    }
}