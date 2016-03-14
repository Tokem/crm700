<?php

class PedidosController extends Tokem_ControllerBase
{

    protected $_usuarios = null;
    protected $_creditos = null;
    protected $_usarCreditos = null;
    protected $_carrinho = null;
    protected $_produtos = null;
    protected $_pedido = null;
    protected $_itens = null;
    protected $_pagSeguro = null;
    protected $_identity = null;

    public function init()
    {
        parent::init();        

        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();        
        $this->_usuarios = new Application_Model_Usuarios();
        $this->_produtos = new Application_Model_Produto();
        $this->_creditos = new Application_Model_Creditos();
        $this->_usarCreditos = new Tokem_Creditos();
        $this->_carrinho  = new Tokem_Carrinho();
        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        $this->_identity = $identity;

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/pedidos/grade.js');

    }

    public function indexAction()
    {   

        $this->_pedido = new Application_Model_Pedidos();

        switch ($this->_identity->usr_permissao) {
            case 'vendedor':
                $lista = $this->_pedido->getAllBySalesman($this->_identity->usr_id);
                break;
            case 'revendedor':
                $lista = $this->_pedido->getAllByAggregate($this->_identity->usr_id);
                break;    
                $lista = $this->_pedido->getAll();
            default:
                break;
        }


        $paginator = Zend_Paginator::factory($lista);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(100);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;
        
    }


    public function ordemDePagamentoAction(){        


        $this->_pedido = new Application_Model_Pedidos();
        $this->_itens = new Application_Model_Itens();
        $dados = $this->getRequest()->getParams();
        $request = $this->getRequest();        

        if($request->isXmlHttpRequest() && $request->isPost()){


            
            if(!is_null($dados["orderInName"])){
                $orderInName = $dados["orderInName"];
            }else{
                $orderInName = $this->_identity->usr_id;
            }

                    $creditos = new Zend_Session_Namespace('Creditos');
                    
                    if(!empty($creditos->usado) && isset($creditos->usado)){
                        $valorCredito = $creditos->usado;
                    }else{
                        $valorCredito = null;
                    }
                    
                    $valorDoPedido = $dados["orderValue"];
                    $pedido = array(
                        "ped_valor"=>$valorDoPedido,
                        "ped_status"=>"pedidio-realizado",
                        "usr_id_fk"=>$orderInName,
                        "ped_creditos_usados"=> $valorCredito,
                    );
            
                    try {

                     /**
                       Inserir Pedido 
                    **/   
                     $lastId = $this->_pedido->insert($pedido);
                     $authNamespace = new Zend_Session_Namespace('Carrinho');   
                     $carrinho = $authNamespace->carrinho;

                         if(!empty($carrinho)){
                            foreach ($carrinho as $key => $value){
                                foreach ($value["numeros"] as $indice => $valor){
                                    $item = array(
                                        "iten_valor"=>$value["valor"],
                                        "iten_numeracao"=>$indice,
                                        "iten_qtd"=>$valor,
                                        "ped_id_fk"=>$lastId,
                                        "pro_id_fk"=>$key,
                                        );
                        /**
                           Inserir Item 
                        **/
                                    $this->_itens->insert($item);

                                }
                            }     
                         }

                    } catch (Zend_Db_Exception $e) {
                        $message  = $e->getMessage();                
                        $stream = @fopen('../log/log.log', 'a', false);
                        $writer = new Zend_Log_Writer_Stream($stream);
                        $logger = new Zend_Log($writer);
                        $logger->err("$message");
                        exit;
                    }

                    $pagamento = new Tokem_PagSeguro();
                    unset($dados["controller"]);
                    unset($dados["action"]);
                    unset($dados["module"]);
                    
                    $xml = $pagamento->processOrder($dados,$lastId);
                    $aux = json_encode($xml);
                    $xml = json_decode($aux);



                    if(isset($xml->paymentLink)){
                        $link = $xml->paymentLink;
                    }else{
                        $link = null;
                    }

                    

                    if(isset($xml->code)){
                        $this->_pagSeguro = new Application_Model_PagSeguro();
                        $pagseguro=array(
                            "lastEventDate"=>$xml->lastEventDate,
                            "code"=>$xml->code,
                            "reference"=>$xml->reference,
                            "type"=>$xml->type,
                            "status"=>$xml->status,
                            "paymentMethod_type"=>$xml->paymentMethod->type,
                            "paymentMethod_code"=>$xml->paymentMethod->code,
                            "paymentLink"=>$link,
                            "grossAmount"=>$xml->grossAmount,
                            "installmentCount"=>$xml->installmentCount,                            
                            "ped_id_fk"=>$xml->reference,
                        );

                        try {
                            $lastId = $this->_pagSeguro->insert($pagseguro);
                            $pagseguro = $this->_pagSeguro->fetchRow("pag_id='$lastId'");
                            $fk = $pagseguro->reference;
                            $pedido = $this->_pedido->fetchRow("ped_id='$fk'");
                            $pedido->pag_seg_id_fk = $pagseguro->pag_id;
                            $pedido->save();

                        } catch (Zend_Db_Exception $e) {
                            $messenger = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');
                            $messenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>ERRO</strong> - Ocorreu um erro inesperado! ao tentar processar seu pagamento emtre em contato conosco!
                            </div>');
                        }
                        
                    }

                    // $retorno = array("resultado"=>"1","url"=>"pedidos");                
                    // echo $status = json_encode($retorno);

                    exit; 


        }
        
    }


    public function carrinhoAction()
    {
        
        $this->view->titulo = "Carrinho";
        $id = $this->getRequest()->getParam('id');
        $authNamespace = new Zend_Session_Namespace('Carrinho');
        $dados = $this->getRequest()->getParams();
        $request = $this->getRequest();        

        if($id=="esvaziar"){                        
            unset($authNamespace->carrinho);
            $authNamespace = new Zend_Session_Namespace('Creditos');    
            unset($authNamespace->total);
            unset($authNamespace->restante);
            unset($authNamespace->credito);
            unset($authNamespace->usado);
            $this->_redirect('/pedidos/carrinho');
            exit; 
        }

    }

    public function resultadoAction(){


        $dados = $this->getRequest()->getParams();
        $request = $this->getRequest();                

       if ($request->isPost()){
          $nome = $dados["pro_nome"];
          $list = $this->_produtos->getAllByName($nome);
        }else{
           $list = array(); 
        }
        
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);
        $this->view->lista = $paginator;
        //$this->view->paginator = $paginator;


    }


    public function somarItemAction()
    {

        $request = $this->getRequest();        
        $dados = $this->getRequest()->getParams();

        if($request->isXmlHttpRequest() && $request->isPost()){
            $this->_carrinho->somarItem($dados["idProdutoSomar"],$dados["numero"]);
            exit;    
        }
        
    }




    public function subtrairItemAction()
    {   

        $request = $this->getRequest();        
        $dados = $this->getRequest()->getParams();

        if($request->isXmlHttpRequest() && $request->isPost()){
            $this->_carrinho->subtrairItem($dados["idProdutoSub"],$dados["numero"]);
            exit;    
        }
        
    }


    public function pagamentoAction()
    {

        
        $authNamespace = new Zend_Session_Namespace('Carrinho');    
        $carrinho = $authNamespace->carrinho;
        if(empty($carrinho)){
            $this->_redirect('/pedidos/grade');
            exit; 
        }


        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/form_validation/vendor/bootstrap/css/bootstrap.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/form_validation/dist/css/formValidation.css');

        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/form_validation/vendor/bootstrap/js/bootstrap.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/form_validation/dist/js/formValidation.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/form_validation/dist/js/framework/bootstrap.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/bootstrapvalidator/src/js/language/pt_BR.js');

        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/vanilla-masker/vanilla-masker.js');
        $this->view->headScript()->appendFile('https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/pagamento/pagamento.js');

        $request = $this->getRequest();        
        $dados = $this->getRequest()->getParams();

        if(!empty($dados["usarcreditos"])){            
            $this->_usarCreditos->usarCreditos($this->_identity->usr_id,$dados["valorPedido"]);
        }

        if(!empty($dados["cancelarcreditos"])){            
            $this->_usarCreditos->cancelarCreditos();
        }

        if($request->isXmlHttpRequest() && $request->isPost()){
            $this->_carrinho->somarItem($dados["id"],$dados["numero"]);
            exit;    
        }

            $pagseguro = new Tokem_PagSeguro();
            $this->view->tokem = $pagseguro->generateTokem();

            if($this->_identity->usr_permissao=="vendedor"){
                $idUser = $this->_identity->usr_id;
                $this->view->carteira = $this->_usuarios->fetchAll("usr_id_fk_carteira='$idUser'","usr_nome ASC");    
            }

            
            
        
    }


    public function excluirItemAction()
    {



        $request = $this->getRequest();        
        $dados = $this->getRequest()->getParams();

        if($request->isXmlHttpRequest() && $request->isPost()){
           $return = $this->_carrinho->excluirItem($dados["idProdutoExcluir"],$dados["numero"]);

           if($return){
            $flashMessenger = $this->_helper->FlashMessenger;   
                      $flashMessenger->addMessage('
                          <div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>Sucesso</strong> - Item excluído!
                          </div>
            ');
             echo true;
             exit;         
           }
           else{
                        $flashMessenger = $this->_helper->FlashMessenger;   
                        $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                        </div>');
           }
           echo "error";
           exit;
        }
                

    }

    public function gradeAction()
    {   
        
        $this->view->titulo = "Novo Pedido";

        $list = $this->_produtos->getAll();
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(20);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;

        $request = $this->getRequest();
        $authNamespace = new Zend_Session_Namespace('Carrinho');

        if ($request->isPost()) {        
        $dados = $this->getRequest()->getParams();
        unset($dados["controller"]);
        unset($dados["action"]);
        unset($dados["module"]);

        if(empty($authNamespace->carrinho)){
            $return = $this->_carrinho->adicionar($dados);
            if($return=="empty_post"){
                  $flashMessenger = $this->_helper->FlashMessenger;   
                  $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>ERRO</strong> - Você precisa escolher ao menos um item para adicionar!
                  </div>');
          
                $this->_helper->redirector('grade');     
            }
        }else{

            $return = $this->_carrinho->verificarAtualizar($dados);
            if($return=="empty_post"){
                  $flashMessenger = $this->_helper->FlashMessenger;   
                  $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>ERRO</strong> - Você precisa escolher ao menos um item para adicionar!
                  </div>');
          
                $this->_helper->redirector('grade');     
            }
        }
        
        $this->view->sucesso = 1;

        }    
                
    }

}