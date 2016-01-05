<?php

namespace Skimia\LaPoste\Printer;


use Skimia\LaPoste\Containers\Container;
use Philo\Blade\Blade;
use Skimia\LaPoste\Lists\ListInterface;

class Printer
{
    protected $html2pdf;
    protected $blade;

    public function loadContainers(array $containers){
        $html = $this->containersHTML($containers);

        $this->html2pdf = new \HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);

        $this->html2pdf->pdf->SetDisplayMode('fullwidth');
        //$html2pdf->setModeDebug();
        $this->html2pdf->writeHTML($html,false);
    }

    public function loadEnvelopes($envelopes,callable $custinfos = null){
        //SET CODE TRACKING


        $html = $this->envelopesHTML($envelopes,$custinfos);

        $path = __DIR__ . '/../../cache/e-volop.html';
        file_put_contents($path,$html);
        $this->html2pdf = new \HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);

        $this->html2pdf->pdf->SetDisplayMode('fullwidth');
        //$html2pdf->setModeDebug();
        $this->html2pdf->writeHTML($html,false);
    }

    /**
     * @return Blade
     */
    protected function getBlade(){
        if(!isset($this->blade)){
            $views = __DIR__ . '/../../views';
            $cache = __DIR__ . '/../../cache';

            $this->blade = new Blade($views, $cache);
        }
        return $this->blade;
    }

    protected function containersHTML(array $containers){
        $blade = $this->getBlade();

        return $blade->view()->make('containers',[
            'containers' => $containers
        ])->render();
    }

    protected function envelopesHTML(ListInterface $envelopes,callable $custinfos = null){
        if(!isset($custinfos))
            $custinfos = function($envelop){return $envelop->getCustomInfo();};

        $blade = $this->getBlade();

        return $blade->view()->make('envelopes',[
            'envelopes' => $envelopes->getEnvelopes(),
            'info' => $custinfos
        ])->render();
    }

    public function write($file){
        return $this->html2pdf->Output($file,'F');
    }

    public function output($pdfName='generated.pdf'){

        ob_end_clean();

        $this->html2pdf->Output($pdfName);
        die();
    }
}