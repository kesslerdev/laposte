<?php

namespace Skimia\LaPoste\Printer;


use Skimia\LaPoste\Containers\Container;
use Philo\Blade\Blade;
use Skimia\LaPoste\Lists\ListInterface;

class Printer
{
    protected $html2pdf;
    protected $blade;
    protected $htmlWrited = false;

    public function loadContainers(array $containers){
        $html = $this->containersHTML($containers);

        $this->html2pdf = new \HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);

        $this->html2pdf->pdf->SetDisplayMode('fullwidth');
        //$html2pdf->setModeDebug();
        $this->html2pdf->writeHTML($html,false);
        $this->htmlWrited  = true;
    }

    public function loadEnvelopes($envelopes,callable $custinfos = null, callable $order = null){
        //SET CODE TRACKING


        $html = $this->envelopesHTML($envelopes,$custinfos,$order);

        /*$path = __DIR__ . '/../../cache/e-volop.html';
        file_put_contents($path,$html);*/
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
            if(function_exists('storage_path'))
                $cache = storage_path() .'/cache';
            else
                $cache = __DIR__ . '/../../cache';

            if(!file_exists($cache))
                mkdir($cache,0777,true);

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

    protected function envelopesHTML( $envelopes,callable $custinfos = null, callable $order = null){
        if(!isset($custinfos))
            $custinfos = function($envelop){return $envelop->getCustomInfo();};

        $blade = $this->getBlade();
        $envelopes = is_subclass_of($envelopes, 'Skimia\LaPoste\Lists\ListInterface') ? $envelopes->getEnvelopes():$envelopes;

        if(isset($order)){
            usort($envelopes,$order);
        }
        return $blade->view()->make('envelopes',[
            'envelopes' => $envelopes,
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