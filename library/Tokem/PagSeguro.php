<?php

class Tokem_PagSeguro
{

    	protected $_email = null;
    	protected $_tokem = null;
    	protected $_url = null;
        protected $_identity = null;
        protected $_usuario = null;
        protected $_endereco = null;
        protected $_pagSeguro = null;


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

        function processOrder($params,$orderId){

            $this->_url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/';
            
            $paramsCard = $this->getCreditCardApiCallParams($params["tokem"], $params["creditCardToken"],$orderId,$params["senderHash"],$params);
            $paramsEncoding = $this->_convertEncoding($paramsCard);
            $paramsString = $this->_convertToCURLString($paramsEncoding);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->_url);
            curl_setopt($ch, CURLOPT_POST, count($paramsEncoding));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paramsString);
            curl_setopt($ch, CURLOPT_TIMEOUT, 45);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            try{
                $response = curl_exec($ch);
            }catch(Exception $e){
                    $message  = $e->getMessage();                
                    $stream = @fopen('../log/pagseguro.log', 'a', false);
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->err("Falha na comunicação com Pagseguro ".$message);
            }

            if (curl_error($ch)) {
                    $message  = $e->getMessage();                
                    $stream = @fopen('../log/pagseguro.log', 'a', false);
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->err('Falha ao tentar enviar parametros ao PagSeguro: %s (%s)'. curl_error($ch) . curl_errno($ch) );
            }
            curl_close($ch);
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string(trim($response));
            
            if (false === $xml) {
                switch($response){
                    case 'Unauthorized':
                    $stream = @fopen('../log/pagseguro.log', 'a', false);
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->err('Token/email não autorizado pelo PagSeguro. Verifique suas configurações no painel.');
                        break;
                    case 'Forbidden':
                    $stream = @fopen('../log/pagseguro.log', 'a', false);
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->err('Acesso não autorizado à Api Pagseguro. Verifique se você tem permissão para
                             usar este serviço. Retorno: ' . var_export($response, true));
                        break;
                    default:
                    $stream = @fopen('../log/pagseguro.log', 'a', false);
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->err('Retorno inesperado do PagSeguro. Retorno: ' . $response);
                        
                }
                
                $messenger = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');
                $messenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERRO</strong> - Ocorreu um erro inesperado! ao tentar processar seu pagamento emtre em contato conosco!
                </div>');

                return false;
            }else{

                //$flashMessenger = $this->_helper->FlashMessenger;
                $messenger = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');
                //$messenger->addMessage('test message');   
                $messenger->addMessage('
                            <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Aviso!</strong> - Seu pedido está sendo processado pelo PagSeguro, dentro de instantes você recebera um email com mais informações!
                            </div>
                        ');
                return $xml;
            }


            
            return true;
               

        }


        /**
         * Convert array values to utf-8
         * @param array $params
         *
         * @return array
         */
        protected function _convertEncoding(array $params)
        {
            foreach ($params as $k => $v) {
                $params[$k] = utf8_decode($v);
            }
            return $params;
        }
        
        /**
         * Convert API params (already ISO-8859-1) to url format (curl string)
         * @param array $params
         *
         * @return string
         */
        protected function _convertToCURLString(array $params)
        {
            $fieldsString = '';
            foreach ($params as $k => $v) {
                $fieldsString .= $k.'='.urlencode($v).'&';
            }
            
            return rtrim($fieldsString, '&');
        }

        public function getItemsParams()
        {


                $authNamespace = new Zend_Session_Namespace('Carrinho');   
                $carrinho = $authNamespace->carrinho;
                $return = array();
                $x=0;
             
                foreach ($carrinho as $key => $value){
                    foreach ($value["numeros"] as $indice => $valor){

                    $x++;                            
                    $return['itemId'.$x] = $key;
                    $return['itemDescription'.$x] = $value["nome"]." Numeracao: ".$indice;
                    $return['itemAmount'.$x] = number_format($value["valor"], 2, '.', '');
                    $return['itemQuantity'.$x] = $valor;

                    }
                }     

            return $return;
        }


        public function getCreditCardApiCallParams($tokem, $tokemCard,$orderId,$senderHash,$params)
        {
            $auth = Zend_Auth::getInstance();
            $this->_identity = $auth->getIdentity();


            if(!empty($params["orderInName"]&&$params["orderInName"]!=0)){
                $this->_usuario = new Application_Model_Usuarios();
                $this->_endereco = new Application_Model_Enderecos();

                $id = $params["orderInName"];
                $user = $this->_usuario->fetchRow("usr_id='$id'",null);
                $endereco = $this->_endereco->fetchRow("usr_id_fk='$id'",null);
                
            }else{
                
                $id = $this->_identity->usr_id;
                $endereco = $this->_endereco->fetchRow("usr_id_fk='$id'",null);
            }

            $pagamento = explode("|", $params["installmentQuantity"]);
            $rest = str_split(preg_replace( '#[^0-9]#', '',"(83)98821-1615"));
            $areaCode = $rest[0].$rest[1];
            
            $config = array(
                'email'             => "vendas@700gauss.com.br",
                'token'             => "24707C512FF041ED96B762FE807CA552",
                'paymentMode'       => 'default',
                'paymentMethod'     =>  'creditCard',
                'receiverEmail'     =>  'vendas@700gauss.com.br',
                'currency'          => 'BRL',
                'creditCardToken'   => $tokemCard,
                'reference'         => $orderId,
                'notificationURL'   => 'http://localhost/crm700/public/pagseguro/notification',
            );

            $sender = array(
                "senderName"                    =>  $params["creditCardHolderName"],
                "senderCPF"                     =>  preg_replace( '#[^0-9]#', '',$params["creditCardHolderCPF"]),
                "senderAreaCode"                =>  $areaCode,
                "senderPhone"                   =>  substr(preg_replace( '#[^0-9]#', '',$user->usr_celular), 2),
                // "senderEmail"                   =>  $user->usr_email,
                "senderEmail"                   =>  "c82292196976740652939@sandbox.pagseguro.com.br",                
                "senderHash"                    =>  $params["senderHash"],
            );

            $shipping = array(    
                "shippingAddressStreet"         =>  $endereco->end_logradouro,
                "shippingAddressNumber"         =>  $endereco->end_numero,
                "shippingAddressComplement"     =>  $endereco->end_complemento,
                "shippingAddressDistrict"       =>  $endereco->end_bairro,
                "shippingAddressPostalCode"     =>  preg_replace( '#[^0-9]#', '',$endereco->end_cep),
                "shippingAddressCity"           =>  $endereco->end_cidade,
                "shippingAddressState"          =>  $endereco->end_estado,
                "shippingAddressCountry"        =>  "BRA",
            );

            $card = array(    
                "creditCardToken"               =>  $tokemCard,
                "installmentQuantity"           =>  $pagamento[0],
                "installmentValue"              =>  number_format($pagamento[1], 2, '.', ''),
                "noInterestInstallmentQuantity" =>  3,
                "creditCardHolderName"          =>  $params["creditCardHolderName"],
                "creditCardHolderCPF"           =>  preg_replace( '#[^0-9]#', '',$params["creditCardHolderCPF"]),
                "creditCardHolderBirthDate"     =>  trim($params["creditCardHolderBirthDate"]),
                "creditCardHolderAreaCode"      =>  $areaCode,
                "creditCardHolderPhone"         =>  substr(preg_replace( '#[^0-9]#', '',$user->usr_celular), 2),
            );

            $billing = array(    
                "billingAddressStreet"         =>  $endereco->end_logradouro,
                "billingAddressNumber"         =>  $endereco->end_numero,
                "billingAddressComplement"     =>  $endereco->end_complemento,
                "billingAddressDistrict"       =>  $endereco->end_bairro,
                "billingAddressPostalCode"     =>  preg_replace( '#[^0-9]#', '',$endereco->end_cep),
                "billingAddressCity"           =>  $endereco->end_cidade,
                "billingAddressState"          =>  $endereco->end_estado,
                "billingAddressCountry"        =>  "BRA",
            );
            
            $return = array_merge($config, $sender);
            $return = array_merge($return, $this->getItemsParams());
            $return = array_merge($return, $shipping);
            $return = array_merge($return, $billing);
            $return = array_merge($return, $card);


            return $return;
        }

        //public function getNotificationStatus($notificationCode){

        public function getNotificationStatus(){

        $notificationCode = "06D1FA77-DBDC-405B-8931-D398C90CAE53";    

        $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $notificationCode;
        $client = new Zend_Http_Client($url, array(
            'keepalive' => true
        ));
        
        $client->setParameterGet(
            array(
                'token'=>"vendas@700gauss.com.br",
                'email'=> "24707C512FF041ED96B762FE807CA552",
            )
        );

        $request = $client->request();        
        //var_dump($request);
        exit;

        $resposta = $client->getLastResponse()->getBody();


                
        $stream = @fopen('../log/pagseguroNotification.log', 'a', false);
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->err(sprintf('Retorno do Pagseguro para notificationCode %s: %s', $notificationCode, $resposta));

        libxml_use_internal_errors(true);
        $xml = simplexml_load_string(trim($resposta));
        if (false === $xml) {            
            $stream = @fopen('../log/pagseguroNotification.log', 'a', false);
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->err('Retorno de notificacao XML PagSeguro em formato não esperado. Retorno: ' . $resposta);

        }

        //return $xml;
        var_dump($xml);
        exit;
    }

}