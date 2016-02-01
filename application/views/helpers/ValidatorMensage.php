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
class Zend_View_Helper_ValidatorMensage extends Zend_View_Helper_Abstract {
    
    public function validatorMensage($mensages){
        

       foreach ($mensages as $key => $value) {

       		//echo $key;

       		switch ($key) {
       			case "usr_nome":
       				$campo="Nome";
       				break;
       			case "fis_profissao":
       				$campo="Profissão";
       			break;	
       			case "fis_ocupacao":
       				$campo="Ocupação Atual";	
       				break;
       			case "fis_data_nasc":
       				$campo="Data de Nasccimento";	
       				break;
       			case "fis_cpf":
       				$campo="CPF";	
       				break;
       			case "fis_rg":
       				$campo="RG";	
       				break;
       			case "usr_email":
       				$campo="Email";	
       				break;
       			case "usr_telefone":
       				$campo="Telefone";	
       				break;
       			case "usr_celular":
       				$campo="Celular";	
       				break;
       			case "select_pergunta":
       				$campo="Pergunta";	
       				break;
       			case "que_resposta":
       				$campo="Resposta";	
       				break;
       			case "end_cep":
       				$campo="CEP";	
       				break;
       			case "end_logradouro":
       				$campo="Logradouro";	
       				break;
       			case "end_bairro":
       				$campo="Bairro";	
       				break;
       			case "end_cidade":
       				$campo="Cidade";	
       				break;
       			case "select_estado":
       				$campo="Estado";	
       				break;
       			case "end_numero":
       				$campo="Número";	
       				break;
       			case "end_complemento":
       				$campo="Complemento";	
       				break;
       			case "usr_usuario":
       				$campo="Usuário";	
       				break;
       			case "usr_senha":
       				$campo="Senha";	
       				break;
       			case "repeatpassword":
       				$campo="Repetir Senha";	
       				break;
       			case "usr_id_fk":
       				$campo="Indicado";	
       				break;
       			case "select_permissao":
       				$campo="Permissão";	
       				break;
                            case "usr_id_fk_carteira":
                                   $campo="Código do Vendedor";  
                                   break;
                            ##Mensagens Categoria Produto##              
                            case "cat_nome":
                                   $campo="Nome da categoria";  
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