<?php

class CategoriaController extends Tokem_ControllerBase
{

    protected $_categoria = null;
    protected $_baseUrl = null;

    public function init()
    {
        parent::init();

        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();        
        $this->_categoria = new Application_Model_Categoria();

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/categoria/categoria.js');
    }

    public function indexAction()
    {   
        
        $list = $this->_categoria->fetchAll(null,"cat_id DESC"); 

        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        //$this->view->lista = $paginator;
        $this->view->paginator = $paginator;
    }

    public function cadastrarAction()
    {
        $form = new Application_Form_Categoria();
        $form->setAction($this->_helper->url('cadastrar'));
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();

        if ($request->isPost() && $form->isValid($request->getPost())) {
                    try {

                        $categoria = array("cat_nome"=>$dados["cat_nome"]);

                        $this->_categoria->insert($categoria);
                        $flashMessenger = $this->_helper->FlashMessenger;   
                        $flashMessenger->addMessage('
                            <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Sucesso</strong> - Tudo ocorreu bem!
                            </div>
                            ');

                    } catch (Zend_Db_Exception $e) {
                        echo $e->getMessage();
                        exit;
                        $flashMessenger = $this->_helper->FlashMessenger;   
                        $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                            </div>');

                    }

                    $this->_helper->redirector('index');     
                    exit;
        }



        $this->view->form = $form;
    }

    public function editarAction()
    {
        $form = new Application_Form_Categoria();

        $form->setAction($this->_helper->url('editar'));
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();

        $id = $this->getRequest()->getParam('id');
        $dados = $this->getRequest()->getParams();
        $form->setAction($this->_helper->url('editar/id/' . $id));
        
        /* Obtem um unico usuário através do id passado */
        $categoria = $this->_categoria->find($id)->current();
        $form->populate($categoria->toArray());
        if ($request->isPost() && $form->isValid($request->getPost())) {
            
            try {

                $categoria->cat_nome = $dados["cat_nome"];
                $categoria->save();
                
                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('
                    <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Sucesso</strong> - Tudo ocorreu bem!
                    </div>
                ');
                
            } catch (Zend_Db_Exception $e) {
                echo $e->getMessage();
                        exit;
                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                    </div>');
                
            }

            $this->_helper->redirector('index');     
            exit;

        }

        $this->view->form = $form;
    }

    public function excluirAction(){

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            try {
                
                $dados = $this->getRequest()->getParams();
                $obj = $this->_categoria->find($dados['id'])->current();    
                $obj->delete();    
                
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


}







