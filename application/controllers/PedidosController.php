<?php

class PedidosController extends Tokem_ControllerBase
{

    protected $_usuarios = null;
    protected $_carrinho = null;
    protected $_produtos = null;
    protected $_identity = null;

    public function init()
    {
        parent::init();        

        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();        
        $this->_usuarios = new Application_Model_Usuarios();
        $this->_produtos = new Application_Model_Produto();
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
        $this->view->titulo = "Pedidos";
    }


    public function carrinhoAction()
    {
        $this->view->titulo = "Carrinho";
        $id = $this->getRequest()->getParam('id');
        $authNamespace = new Zend_Session_Namespace('Carrinho');    

        if($id){            
            unset($authNamespace->carrinho);
            $this->_redirect('/pedidos/carrinho');
            exit; 
        }

    }

    public function detalhesAction()
    {
        $this->view->titulo = "Detalhes do Pedido";
    }


    public function excluirItemAction()
    {

        $request = $this->getRequest();        
        $dados = $this->getRequest()->getParams();

        if($request->isXmlHttpRequest() && $request->isPost()){
           $this->_carrinho->excluirItem($dados["id"],$dados["numero"]);
        }
                

    }

    public function gradeAction()
    {   
        
        $this->view->titulo = "Novo Pedido";

        $list = $this->_produtos->getAll();
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(4);

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
            $this->_carrinho->adicionar($dados);
        }else{
            $this->_carrinho->verificarAtualizar($dados);
        }
        
        $this->view->sucesso = 1;

        }    
                
    }

}