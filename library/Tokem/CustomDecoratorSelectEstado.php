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
class Tokem_CustomDecoratorSelectEstado extends Zend_Form_Decorator_Abstract{
 
    public function render($content)
    {   


        $element = $this->getElement();
        $label   = htmlentities($element->getLabel());
        $type = $element->type;
        $name = $element->elemName;
        $multiOptions = $element->multiOptions;
        $id =$element->elemName;
        // $labelClass = $element->labelClass;
        // $spanClass = $element->spanClass;
        $markup='';

        if(!empty($type) && !empty($name) && !empty($multiOptions)  && is_array($multiOptions)){
         foreach($multiOptions as $key=>$value){
           $markup .='<option value="'.$key.'">'.$key.'<option>';                    
         }
        }

        $select = '<div class="col-xs-12 col-sm-4"><div class="form-group"><label>'.$label.'</label> <select id="select_estado" class="form-control" name="select_estado">'."<option>Selecione o Estado<option>".$markup.'</select></div></div>';
 
        return $select;
        

        
    }
}