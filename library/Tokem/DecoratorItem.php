<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Tokem_DecoratorItem extends Zend_Form_Decorator_Abstract{
 
    protected $_format=null;


    public function render($content)
    {   
        $tag = "<div class=\"edit delete convert options-menu clearfix\" id=\"%s\"> 
                    <input type=\"checkbox\" name=\"%s\" value=\"%s\" %s>
                    <label for=\"%s\">%s</label>
                    <textarea type=\"text\" class=\"field full single-line js-checkitem-input\" name=\"%s\" style=\"height: 66px; margin-top: 0px; margin-bottom: 4px;\">%s</textarea>   
                    <div class=\"edit-controls clearfix\" style=\"margin-lef:50px\"> 
                        <input type=\"button\" class=\"primary confirm js-save-edit\" value=\"Salvar\"> 
                        <a href=\"#\" class=\"icon-lg icon-close dark-hover cancel js-cancel-edit\"></a> 
                        <a href=\"#\" class=\"option delete js-delete-item\">Deletar</a> 
                        <a class=\"option options-menu dark-hover js-open-editing-menu\" href=\"#\"> 
                        <span class=\"icon-lg icon-menu\"> </span>
                    </a> 
                    </div> 
                </div>";
      
        $this->_format=$tag;
        
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());
        $label   = htmlentities($element->getLabel());
        
        if($value == 1){
            $checked = 'checked';
        }else{
            $checked = '';
        }
        
        $markup  = sprintf($this->_format, $id, $name, $value, $checked , $name, $label, "text_".$label, $label);
        return $markup;
    }
}
?>
