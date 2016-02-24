<?php

class Tokem_PagSeguro
{

	protected $_email = null;
	protected $_tokem = null;
	protected $_url = null;

	function generateTokem(){

		$this->_email = 'vendas@700gauss.com.br';
        $this->_tokem = '24707C512FF041ED96B762FE807CA552';
        $this->_url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, sprintf('email=%s&token=%s', $this->_email, $this->_tokem));
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $ret = curl_exec($ch);
        curl_close($ch);
        libxml_use_internal_errors(true);
        $valid = simplexml_load_string($ret) !== false;

        if ($valid){
            $pagSeguro = new Zend_Session_Namespace('PagSeguro');    
            unset($pagSeguro->tokem);
            $pagSeguro->tokem;
            $xml = simplexml_load_string($ret);            
            return $xml->id;    
        }
	}

}