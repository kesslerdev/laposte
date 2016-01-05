<?php

namespace Skimia\LaPoste\Lists;

interface ListInterface
{

    /**
     * @return EnvelopeInterface[]
     */
    public function getEnvelopes();

    public function count();

}