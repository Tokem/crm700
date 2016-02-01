<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tokem_Custom_Decorator_Date
 *
 * @author rodolfo
 */
class Tokem_CustomDecoratorRadio extends Zend_Form_Decorator_Abstract{
 
    public function render($content)
    {
        $element = $this->getElement();

        $label   = htmlentities($element->getLabel());
        $type = $element->type;
        $name = $element->elemName;
        $multiOptions = $element->multiOptions;
        // $labelClass = $element->labelClass;
        // $spanClass = $element->spanClass;
        $markup='';

        if(!empty($type) && !empty($name) && !empty($multiOptions)  && is_array($multiOptions)){
         foreach($multiOptions as $key=>$value){
           $markup .='<label><input type="radio" name="'.$name.'" value="'.$key.'"> <span>'.$value.'</span></label>';                    
         }
        }
        return"<div class='col-xs-12 col-sm-4'><div class='form-group><div class='radiobuttons'>$label<br/>".$markup."</div></div></div>";

        // '<label for="fis_data_nasc">Data Nascimento:</label>
    }
}