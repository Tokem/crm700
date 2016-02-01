<?php

class PerfilController extends Tokem_ControllerBase
{

    public function init()
    {
        $this->_helper->layout->disableLayout();
    }

    public function indexAction()
    {
    	$form = new Application_Form_Perfil();
        $form->setAction($this->_helper->url('cadastrar'));
        $this->view->form = $form;
        
    }


}

