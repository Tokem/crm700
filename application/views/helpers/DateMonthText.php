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
class Zend_View_Helper_DateMonthText extends Zend_View_Helper_Abstract {
    
    public function dateMonthText($value){
        
       $mes = array(
       	"01"=>"Jan", 
        "02"=>"Fev", 
        "03"=>"Mar", 
        "04"=>"Abr", 
        "05"=>"Mai", 
        "06"=>"Jun", 
        "07"=>"Jul", 
        "08"=>"Ago", 
        "09"=>"Set", 
        "10"=>"Out", 
        "11"=>"Nov", 
        "12"=>"Dez"
       	);
	   

       $string =strtr($value, $mes);

		return $string;

    }
    
}
?>
