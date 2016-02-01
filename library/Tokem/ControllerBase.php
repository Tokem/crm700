<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerBase
 *
 * @author Rodolfo almeida
 */
class Tokem_ControllerBase extends Zend_Controller_Action {
   
    
    protected $_acl = null;
    protected $_usuarios = null;
    protected $_notificacao = null;
    public $identity = null;
    

    public function init()
    {
         parent::init();
        
        $this->_usuarios = new Application_Model_Usuarios();
        $this->_notificacao = new Application_Model_Notificacao();
       

        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        $this->identity = $identity;

        
        switch ($this->identity->usr_permissao) {
            case 'administrador':
               $this->view->notificacoes = $this->_notificacao->fetchAll("not_ativo=1","not_id DESC LIMIT 4");
               $this->view->solicitacoes = $this->_usuarios->fetchAll("usr_ativo=0",null);
                break;
            case 'revendedor':
            $codigo = (int)$this->identity->usr_id;
               $this->view->notificacoes = $this->_notificacao->fetchAll("usr_id_fk='$codigo' AND not_ativo=1","not_id DESC LIMIT 4");
                break;
            case 'vendedor':
               $codigo = (int)$this->identity->usr_id;
               $this->view->notificacoes = $this->_notificacao->fetchAll("usr_id_fk='$codigo' AND not_ativo=1","not_id DESC LIMIT 4");
                break;        
            // default:
            //     $this->view->notificacoes = $this->_notificacao->fetchAll("not_ativo=1","not_id DESC LIMIT 4");
            //     break;
        }


        $acl = new Zend_Acl();
        $acl->getRoles(); //array
        $recurssos = $acl->getResources(); //array        


        //Modo de manutenção
        $ip = $_SERVER['REMOTE_ADDR'];

        // if($ip!='189.81.41.181'){
        //     $this->_redirect('/aviso/suporte');
        //     exit;
        // }


        $controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $action =Zend_Controller_Front::getInstance()->getRequest()->getActionName();

        $this->_acl = Zend_Registry::get('acl');
        $actionName = $this->_request->getControllerName();
        
        
        if(!isset($identity->usr_permissao)){
           $this->_redirect('/login');
           exit; 
        }    

        if(!$this->_acl->isAllowed("$identity->usr_permissao",$actionName)){
            $this->_redirect('/login');
            exit;
        }

        
        $this->_acl = Zend_Registry::get('acl');
        $actionName = $this->_request->getControllerName();
        
    
        $session = new Zend_Session_Namespace( 'Zend_Auth' );
        $session->setExpirationSeconds( 864000 );
        Zend_Session::rememberMe(864000);
        $timeLeftTillSessionExpires = $_SESSION [ '__ZF' ][ 'Zend_Auth' ][ 'ENT' ]  - time ();

        $env =  getenv('APPLICATION_ENV');
        if($env=="production"){
            error_reporting(0);
            ini_set('display_errors', 'off');        
        } 

        
    }
    
    
    
}

?>