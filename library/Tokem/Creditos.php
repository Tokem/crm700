<?php

class Tokem_Creditos{


	protected $_creditos = null;
	protected $_usuario = null;

	public function cancelarCreditos(){
		
		$authNamespace = new Zend_Session_Namespace('Creditos');    
        unset($authNamespace->total);
        unset($authNamespace->restante);
        unset($authNamespace->credito);
        unset($authNamespace->usado);

        return true;
	}

	public function usarCreditos($usuarioId,$valorPedido){

		$this->_creditos = new Application_Model_Creditos();
		$this->_usuario = new Application_Model_Usuarios();			
		$usuario = $this->_usuario->fetchRow("usr_id='$usuarioId'");
		$credito = $usuario->usr_creditos;

		if($credito > $valorPedido){

			$creditoRestante  = $credito - $valorPedido;
			
			$authNamespace = new Zend_Session_Namespace('Creditos');    
            unset($authNamespace->total);
            unset($authNamespace->restante);
            unset($authNamespace->cretidos);
            unset($authNamespace->usado);

			$authNamespace->total = $valorRestante = 0.00; 
			$authNamespace->restante = $creditoRestante;
			$authNamespace->credito = true;
			$authNamespace->usado = $valorPedido;

			

			return true;

		}else if($valorPedido > $credito){

			$creditoRestante = 0.00;

			$valorRestante = $valorPedido - $credito;

			$authNamespace = new Zend_Session_Namespace('Creditos');    
            unset($authNamespace->total);
            unset($authNamespace->restante);
            unset($authNamespace->cretidos);
            unset($authNamespace->usado);

			$authNamespace->total = $valorRestante; 
			$authNamespace->restante = $creditoRestante;
			$authNamespace->credito = true;
			$authNamespace->usado = $credito;

			return true;
		}

	}

}