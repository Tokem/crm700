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
class Tokem_CustomDecorator extends Zend_Form_Decorator_Abstract{
 
    protected $_format=null;


    public function render($content)
    {   
        $tag = "<div class=\"col-xs-12 col-sm-4\"><div ident=\"%s\" class=\"form-group\"><label for=\"%s\">%s</label>"
              ."<input class=\"form-control\" id=\"%s\" name=\"%s\" type=\"text\" value=\"%s\"/>"
              ."</div></div>";
      
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
