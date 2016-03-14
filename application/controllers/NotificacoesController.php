<?php

class NotificacoesController extends Tokem_ControllerBase
{

    protected $_notificacao = null;

    public function init()
    {
        parent::init();
        $this->_notificacao = new Application_Model_Notificacao();
        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();        
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/notificacoes/index.js');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
    }

    public function indexAction()
    {


        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        $this->identity = $identity;

        switch ($this->identity->usr_permissao) {
            case 'administrador':
               $list = $this->_notificacao->fetchAll(null,"not_id DESC");
                break;
            case 'revendedor':
            $codigo = (int)$this->identity->usr_id;
               $list = $this->_notificacao->fetchAll("usr_id_fk='$codigo'","not_id DESC");
                break;
            case 'vendedor':
            $codigo = (int)$this->identity->usr_id;
               $list = $this->_notificacao->fetchAll("usr_id_fk='$codigo'","not_id DESC");
                break;        
        }

        
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(100);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;
        
    }

    public function excluirAction(){

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $this->_dbAdapter->beginTransaction();
            
            try {
                
                $dados = $this->getRequest()->getParams();
                $obj = $this->_notificacao->find($dados['id'])->current();    
                $obj->delete();    
                
                $this->_dbAdapter->commit();
                
            $flashMessenger = $this->_helper->FlashMessenger;   
            $flashMessenger->addMessage('
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Sucesso</strong> - Tudo ocorreu bem!
                        </div>
                    ');
            
               echo true;
               exit;
            } catch (Zend_Db_Exception $e) {
                
                $this->_dbAdapter->rollBack();
                
                $flashMessenger = $this->_helper->FlashMessenger;   
                            $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                            </div>');
                exit;
            }
        }
    }

    public function verAction()
    {


        $dados = $this->getRequest()->getParams();
        $id = $dados["id"];
        $notificacao = $this->_notificacao->fetchRow("not_id='$id'");
                    
               try {
                $notificacao->not_ativo = 0;
                $notificacao->not_data_leitura = Date("Y:m:d H:m:s");
                $notificacao->save();
                echo 1;
                exit;   
               } catch (Zend_Db_Exception $e) {
                   echo 0;
                   exit;   
               }

        

        exit;
    }



    public function pagseguroAction(){

        $this->_notificacao = new Tokem_PagSeguro();        
        $this->_notificacao->getNotificationStatus();
        exit;


    }




}





