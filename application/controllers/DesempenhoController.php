<?php

class DesempenhoController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/relogios/assets/css/style.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/relogios/assets/js/jquery-migrate-1.2.1.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/relogios/assets/js/jquery-ui-1.10.3.custom.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/relogios/assets/js/jquery.knob.modified.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/relogios/assets/js/pages/index.js');
    }

    public function indexAction()
    {
        // action body
    }


}

