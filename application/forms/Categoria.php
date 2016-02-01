<?php

class Application_Form_Categoria extends Zend_Form
{

    public function init()
    {
        $validarTamanho = new Zend_Validate_StringLength(2,100);
        $validarEmail = new Zend_Validate_EmailAddress();
        
        /*filtros*/
        $stripTags =  new Zend_Filter_StripTags();
        $trim = new Zend_Filter_StringTrim();
    
        $customDecorateInput = new Tokem_CustomDecorator;
        $customDecorateSelectVende = new Tokem_CustomDecoratorSelectVende;
        $customDecorateSelectEstado = new Tokem_CustomDecoratorSelectEstado;
        $customDecorateSelectPermissao = new Tokem_CustomDecoratorSelectPermissao;
        $customDecorateButton= new Tokem_CustomDecoratorButton;


        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        

        /*Elementos do formulario*/
        $nome = new Zend_Form_Element_Text('cat_nome');
        $nome->setLabel('Nome da categoria:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));

        $submit   = new Zend_Form_Element('btn_enviar', array(
            'elemName'=>'btn_enviar',
            'label'=>'Enviar Dados',
            'type' =>'submit',
            'required' => false,
            'decorators' => array($customDecorateButton),
            'setAttrib'=>array('name','btn_enviar')
        )); 
        
        $this->addElements(array(
            $nome,
            $submit,
        ));     
    }

}

