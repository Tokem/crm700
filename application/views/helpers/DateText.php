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
class Zend_View_Helper_DateText extends Zend_View_Helper_Abstract {
    
    public function dateText($value){
        
       $semana = array(
       	"Sunday"=>"Dom", 
       	"Monday"=>"Seg", 
       	"Tuesday"=>"Ter", 
       	"Wednesday"=>"Qua", 
       	"Thursday"=>"Qui", 
       	"Friday"=>"Sex", 
       	"Saturday"=>"Sab",
       	);
	   

       $string =strtr($value, $semana);

		return $string;

    }
    
}
?>
