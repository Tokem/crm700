<?php

class Application_Form_Produto extends Zend_Form
{   

    protected $_categoria = null;

    public function init()
    {


        $this->_categoria = new Application_Model_Categoria();
        $validarTamanho = new Zend_Validate_StringLength(1,100);
        $validarEmail = new Zend_Validate_EmailAddress();
        
        /*filtros*/
        $stripTags =  new Zend_Filter_StripTags();
        $trim = new Zend_Filter_StringTrim();
    
        $customDecorateInput = new Tokem_CustomDecorator;
        $customDecorateSelectVende = new Tokem_CustomDecoratorSelectVende;
        $customDecorateSelectCategoria = new Tokem_CustomDecoratorSelectCategoria;
        $customDecorateSelectPermissao = new Tokem_CustomDecoratorSelectPermissao;
        $customDecorateButton= new Tokem_CustomDecoratorButton;


        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();


        $categoria = $this->createElement('select', 'select_categoria', array(
            'label' => 'Categoria',
            'elemName'=>'select_categoria',
            'required' => true,'class'=>'form-control',
        ));   


        // var_dump($this->_categoria->fetchAll());
        // exit;

        foreach ($this->_categoria->fetchAll() as $row) {
            $categoria->addMultiOption($row['cat_id'], $row['cat_nome']);
        }

        $categoria->setDecorators(array($customDecorateSelectCategoria));

        /*Elementos do formulario*/
        $nome = new Zend_Form_Element_Text('pro_nome');
        $nome->setLabel('Nome do Produto:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));


        $descricao = new Zend_Form_Element_Text('pro_descricao');
        $descricao->setLabel('Descrição:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));    


        $identificador = new Zend_Form_Element_Text('pro_identificador');
        $identificador->setLabel('Identificador externo:')
             ->setRequired(false)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));

        
        $valor = new Zend_Form_Element_Text('pro_valor');
        $valor->setLabel('Valor R$:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));


        $pontuacao = new Zend_Form_Element_Text('pro_pontos');
        $pontuacao->setLabel('Pontos:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));     


        $numeros = new Zend_Form_Element_MultiCheckbox('pro_tamanhos');
        $numeros->setLabel('Numeração:')
        ->setRequired(true)
        ->addMultioption("33","33")
        ->addMultioption("34","34")  
        ->addMultioption("35","35")  
        ->addMultioption("36","36")  
        ->addMultioption("37","37")  
        ->addMultioption("38","38")  
        ->addMultioption("39","39")  
        ->addMultioption("40","40")  
        ->addMultioption("41","41")  
        ->addMultioption("42","42")  
        ->addMultioption("43","43")  
        ->addMultioption("44","44")  
        ->addMultioption("45","45")  
        ->addMultioption("Unico","U")
        ->addMultioption("pp","PP") 
        ->addMultioption("p","P")  
        ->addMultioption("m","M")  
        ->addMultioption("g","G")  
        ->addMultioption("gg","GG");

        $file = new Zend_Form_Element_File('imagens');
        $file->setLabel('Imagem: Tamanho Ideal (650px x 650px)')
        ->setValueDisabled(true)
        ->setAttrib('class', 'input-xxlarge')        
        ->setMultiFile(1)       
        ->addValidator('Count', false,array('min' => 0,
                            'max' => 5,
                      ))
             ->addValidator(new Zend_Validate_File_Size('5MB'))
             ->addValidator('Extension', false, 'jpg,png,gif')
             ->addValidator('ImageSize', false,
                      array('minwidth' => 80,
                            'maxwidth' => 3500,
                            'minheight' => 80,
                            'maxheight' => 3500)
                      );   
          

        $submit   = new Zend_Form_Element('btn_enviar', array(
            'elemName'=>'btn_enviar',
            'label'=>'Enviar Dados',
            'type' =>'submit',
            'required' => false,
            'decorators' => array($customDecorateButton),
            'setAttrib'=>array('name','btn_enviar')
        ));


        $this->addElements(array(
            $identificador,
            $categoria,
            $nome,
            $descricao,
            $valor,
            $pontuacao,
            $numeros,
            $file,
            $submit
        ));               
    }

}

