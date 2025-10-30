<?php

/**
 * SipFun Active Record
 * @author  <bruno>
 */
class SipFun extends TRecord
{
    const TABLENAME = 'sip_fun';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL) //$callObjectLoad = TRUE)
    {
        parent::__construct($id);          // $callObjectLoad);
        
        parent::addAttribute('emp');
        parent::addAttribute('mat');
        parent::addAttribute('des');
        parent::addAttribute('cpf');
        parent::addAttribute('mae');
        parent::addAttribute('nac');
        parent::addAttribute('nas');
        parent::addAttribute('lug');
        parent::addAttribute('sit');
        parent::addAttribute('pai');
        parent::addAttribute('sex');
        parent::addAttribute('rac');
        parent::addAttribute('gue');
        parent::addAttribute('cpf');
        parent::addAttribute('ide');
        parent::addAttribute('ctp');
        parent::addAttribute('cte');
        parent::addAttribute('ctu');
        parent::addAttribute('ctm');
        parent::addAttribute('cam');
        parent::addAttribute('pis');
        parent::addAttribute('ssp');
        parent::addAttribute('dti');
        parent::addAttribute('ser');
        parent::addAttribute('dti');
        parent::addAttribute('cep');
        parent::addAttribute('end');
        parent::addAttribute('cpl');
        parent::addAttribute('cid');
        parent::addAttribute('ema');
        parent::addAttribute('bai');
        parent::addAttribute('num');
        parent::addAttribute('esr');
        parent::addAttribute('tel');
        parent::addAttribute('cel');        
        parent::addAttribute('rvt');
        parent::addAttribute('can');
        parent::addAttribute('ccn');
        parent::addAttribute('san');
        parent::addAttribute('def');
        parent::addAttribute('ins');
        parent::addAttribute('rgu');
        parent::addAttribute('etg');
        parent::addAttribute('age');
        parent::addAttribute('con');

        parent::addAttribute('etgdat');
        parent::addAttribute('etgnat');
        parent::addAttribute('etgsit');
        parent::addAttribute('etgfil');

        parent::addAttribute('depnom');
        parent::addAttribute('depcpf');
        parent::addAttribute('deppar');
        parent::addAttribute('depnas');
        parent::addAttribute('depsex');
        parent::addAttribute('depinc');

        parent::addAttribute('depnom2');
        parent::addAttribute('depcpf2');
        parent::addAttribute('deppar2');
        parent::addAttribute('depnas2');
        parent::addAttribute('depsex2');
        parent::addAttribute('depinc2');

        parent::addAttribute('depnom3');
        parent::addAttribute('depcpf3');
        parent::addAttribute('deppar3');
        parent::addAttribute('depnas3');
        parent::addAttribute('depsex3');
        parent::addAttribute('depinc3');

        parent::addAttribute('depnom4');
        parent::addAttribute('depcpf4');
        parent::addAttribute('deppar4');
        parent::addAttribute('depnas4');
        parent::addAttribute('depsex4');
        parent::addAttribute('depinc4');

        parent::addAttribute('depnom5');
        parent::addAttribute('depcpf5');
        parent::addAttribute('deppar5');
        parent::addAttribute('depnas5');
        parent::addAttribute('depsex5');
        parent::addAttribute('depinc5');

        parent::addAttribute('cad_dat');
        parent::addAttribute('pathrg');
        parent::addAttribute('pathcpf');
        parent::addAttribute('pathresidencia');
        parent::addAttribute('patheleitor');
        parent::addAttribute('pathreserva');
        parent::addAttribute('pathpis');
        parent::addAttribute('pathvacina');
        parent::addAttribute('pathnascas');
        parent::addAttribute('pathescola');
        parent::addAttribute('pathctps');
        parent::addAttribute('pathcurriculo');
        parent::addAttribute('ele');
        parent::addAttribute('sec');
        parent::addAttribute('zon');
        parent::addAttribute('pathdepcpf');
        parent::addAttribute('depirf');
        parent::addAttribute('depsaf');
        parent::addAttribute('depirf2');
        parent::addAttribute('depsaf2');
        parent::addAttribute('depirf3');
        parent::addAttribute('depsaf3');
        parent::addAttribute('depirf4');
        parent::addAttribute('depsaf4');
        parent::addAttribute('depirf5');
        parent::addAttribute('depsaf5');
        parent::addAttribute('status');

        


    }


}
?>