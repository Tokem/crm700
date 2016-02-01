<?php

class AgregadosController extends Tokem_ControllerBase
{

	protected $_usuarios = null;
	protected $_identity = null;

    public function init()
    {
        parent::init();

        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();        
        $this->_usuarios = new Application_Model_Usuarios();


        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        $this->_identity = $identity;
        
    }

    public function indexAction()
    {
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');

        $id = $this->_identity->usr_id;

        $list = $this->_usuarios->fetchAll("usr_id_fk_agregado=$id","usr_id DESC");      
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;
    }


}

