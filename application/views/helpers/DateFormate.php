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
class Zend_View_Helper_DateFormate extends Zend_View_Helper_Abstract {
    
    public function dateFormate($value){
        
       $aux = explode('-', $value);
       $data = $aux[2] . "/".$aux[1]."/".$aux[0];
       return $data;

    }
    
}
?>
