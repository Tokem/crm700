<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateFormat
 *
 * @author Rodolfo almeida
 */

/*Formata a data */
class Zend_View_Helper_DateTimeFormate extends Zend_View_Helper_Abstract {
    
    public function dateTimeFormate($value){


            if(isset($value)){
                $data = explode('-', $value);
                $data0 = explode(' ', $data[2]);
                $data1 = explode(':', $data0[1]);

                $dia = $data0[0];
                $mes = $data[1];
                $ano = $data[0];
                $hora = $data1[0];
                $minuto = $data1[1];
                $segundo = $data1[2];

                $data = $dia . "/" . $mes . "/" . $ano . " " . $hora . ":" . $minuto . ":" . $segundo;
                
                return $data;
            }else{
                return '<span class="label label-danger">Sem data</span>
';
            }
        
       		

    }
    
}
?>
