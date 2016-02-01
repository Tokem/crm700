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
class Zend_View_Helper_TimeFormate extends Zend_View_Helper_Abstract {
    
    public function timeFormate($value){
        
       		$data = explode(':', $value);

            $hora = $data[0];
            $minuto = $data[1];
            

            $data = $hora . ":" . $minuto;
            
            return $data;

    }
    
}
?>
