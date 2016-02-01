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
class Zend_View_Helper_ValidatorMensageProduct extends Zend_View_Helper_Abstract {
    
    public function validatorMensageProduct($mensages){
        

       foreach ($mensages as $key => $value) {

       		//echo $key;

       		switch ($key) {
       			case "pro_nome":
       				$campo="Nome do Produto";
       				break;
                  case "pro_descricao":
                         $campo="Descrição";
                         break;       
                   case "pro_valor":
                         $campo="Valor";
                         break;             
                   case "pro_pontos":
                         $campo="Pontos";
                         break;
                    case "pro_tamanhos":
                         $campo="Numeração";
                         break;
                    case "select_categoria":
                         $campo="Categoria";
                         break;                                                                                           
       			default:
       				$campo = '';
       				break;
       		}

		  	foreach ($value as $key2 => $value2) {

		  		echo "<div class='alert alert-danger alert-dismissible' role='alert'><strong>".$campo."</strong> - ".$value2."</div>";
		  	}
		}

    }
    
}
?>