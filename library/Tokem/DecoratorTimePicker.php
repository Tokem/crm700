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
class Tokem_DecoratorTimePicker extends Zend_Form_Decorator_Abstract{
 
    protected $_format=null;


    public function render($content)
    {   
        $tag = "<div id=\"%s-datepicker\" class=\"input-append\"><label for=\"%s\">%s</label><br/>"
              ."<input id=\"%s\" name=\"%s\" type=\"text\" value=\"%s\" data-format=\"hh:mm\" />"
              ."<span class=\"add-on\">&nbsp;<i data-time-icon=\"icon-time\" data-date-icon=\"icon-calendar\"></i></span></div>";
      
        $this->_format=$tag;
        
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());
 
        $markup  = sprintf($this->_format,$id, $name, $label, $id, $name, $value);
        return $markup;
    }
}
