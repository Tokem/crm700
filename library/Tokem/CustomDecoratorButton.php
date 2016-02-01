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
class Tokem_CustomDecoratorButton extends Zend_Form_Decorator_Abstract{
 
    protected $_format=null;


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

        if(!empty($type) && !empty($name)){
         
           $markup .='<div  class="col-xs-12 col-sm-4"><div class="form-group"><button id="btn_enviar" type="submit" class="btn btn-primary">'.$label.'</button></div></div>';                    
         
        }

        return $markup;

        
    }
}
