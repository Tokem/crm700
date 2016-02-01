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
class Zend_View_Helper_DateTextWeek extends Zend_View_Helper_Abstract {
    
    public function dateTextWeek($value){
        
       $semana = array(
       	"Sun"=>"Dom", 
       	"Mon"=>"Seg", 
       	"Tue"=>"Ter", 
       	"Wed"=>"Qua", 
       	"Thu"=>"Qui", 
       	"Fri"=>"Sex", 
       	"Sat"=>"Sab",
       	);
	   

       $string =strtr($value, $semana);

		return $string;

    }
    
}
?>
