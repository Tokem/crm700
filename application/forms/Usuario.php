<?php

class Application_Form_Usuario extends Zend_Form
{


    protected $_vendedor= null;

    public function init()
    {
         /*validadores*/


         $this->_vendedor = new Application_Model_Usuarios();
         
        $validarTamanho = new Zend_Validate_StringLength(1,100);
        $validarEmail = new Zend_Validate_EmailAddress();
        
        /*filtros*/
        $stripTags =  new Zend_Filter_StripTags();
        $trim = new Zend_Filter_StringTrim();
    
        $customDecorateInput = new Tokem_CustomDecorator;
        $customDecorateSelectVende = new Tokem_CustomDecoratorSelectVende;
        $customDecorateSelectEstado = new Tokem_CustomDecoratorSelectEstado;
        $customDecorateSelectPermissao = new Tokem_CustomDecoratorSelectPermissao;
        $customDecorateSelectVendedor = new Tokem_CustomDecoratorSelectVendedor;
        $customDecorateButton= new Tokem_CustomDecoratorButton;


        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        


        /*Elementos do formulario*/
        $nome = new Zend_Form_Element_Text('usr_nome');
        $nome->setLabel('Nome:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));



        $profissao = new Zend_Form_Element_Text('fis_profissao');
        $profissao->setLabel('Profissao:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));


        $ocupacao = new Zend_Form_Element_Text('fis_ocupacao');
        $ocupacao->setLabel('Ocupação Atual:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));    


        $nasc = new Zend_Form_Element_Text('fis_data_nasc');
        $nasc->setLabel('Data Nascimento:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));

        
        $cpf = new Zend_Form_Element_Text('fis_cpf');
        $cpf->setLabel('CPF:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));


            
        $rg = new Zend_Form_Element_Text('fis_rg');
        $rg->setLabel('RG:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));
                  
        
        $email = new Zend_Form_Element_Text('usr_email');
        $email->setLabel('Email')
              ->setRequired(true)
              ->addFilter($stripTags)
              ->addFilter($trim)
              ->addValidator($validarEmail)
              ->setDecorators(array($customDecorateInput));
        
        $telefone = new Zend_Form_Element_Text('usr_telefone');
        $telefone->setLabel('Telefone')
              ->setRequired(true)
              ->addFilter($stripTags)
              ->addFilter($trim)
              ->setDecorators(array($customDecorateInput));

        $celular = new Zend_Form_Element_Text('usr_celular');
        $celular->setLabel('Celular')
              ->setRequired(true)
              ->addFilter($stripTags)
              ->addFilter($trim)
              ->setDecorators(array($customDecorateInput));     


        $pergunta   = new Zend_Form_Element('select_pergunta', array(
            'elemName'=>'que_pergunta',
            'label'=>'Vende alguma linha de produto?',
            'type' =>'select',
            'required' => true,
            'multiOptions' => array(""=>"Selecione","Sim"=>"Sim", "Não"=>'Não'),
            'decorators' => array($customDecorateSelectVende),
        ));

    

        $resposta = new Zend_Form_Element_Text('que_resposta');
        $resposta->setLabel('Se Sim qual?')
              ->addFilter($stripTags)
              ->addFilter($trim)
              ->setDecorators(array($customDecorateInput));      
        


        $this->addDisplayGroup(array(
                    $nome,
                    $profissao,
                    $ocupacao,
                    $nasc,
                    $cpf,
                    $rg,
                    $email,
                    $telefone,
                    $celular,
                    $pergunta,
                    $resposta,
                    ), 'Perfil', array('legend'=>'Dados Pessoais')); 


        //endereço
        /*Elementos do formulario*/

        $cep = new Zend_Form_Element_Text('end_cep');
        $cep->setLabel('CEP:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));

        $logradouro = new Zend_Form_Element_Text('end_logradouro');
        $logradouro->setLabel('Logradouro:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));


        $bairro = new Zend_Form_Element_Text('end_bairro');
        $bairro->setLabel('Bairro:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));



        $cidade = new Zend_Form_Element_Text('end_cidade');
        $cidade->setLabel('Cidade:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));

        $estado   = new Zend_Form_Element('select_estado', array(
            'elemName'=>'end_estado',
            'label'=>'Estado',
            'type' =>'select',
            'required' => true,
            'multiOptions' => 
            array(
             ""=>"Selecione o estado",
             "AC"=>"Acre",
             "AL"=>"Alagoas", 
             "AM"=>"Amazonas", 
             "AP"=>"Amapá",
             "BA"=>"Bahia",
             "CE"=>"Ceará",
             "DF"=>"Distrito Federal",
             "ES"=>"Espírito Santo",
             "G"=>"Goiás",
             "MA"=>"Maranhão",
             "MT"=>"Mato Grosso",
             "MS"=>"Mato Grosso do Sul",
             "MG"=>"Minas Gerais",
             "PR"=>"Pará",
             "PB"=>"Paraíba",
             "PR"=>"Paraná",
             "PE"=>"Pernambuco",
             "PI"=>"Piauí",
             "RJ"=>"Rio de Janeiro",
             "RN"=>"Rio Grande do Norte",
             "RO"=>"Rondônia",
             "RS"=>"Rio Grande do Sul",
             "RO"=>"Roraima",
             "SC"=>"Santa Catarina",
             "SE"=>"Sergipe",
             "SP"=>"São Paulo",
             "TO"=>"Tocantins"),
            'decorators' => array($customDecorateSelectEstado)
        ));

        $numero = new Zend_Form_Element_Text('end_numero');
        $numero->setLabel('Número:')
             ->setRequired(true)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));

        $complemento = new Zend_Form_Element_Text('end_complemento');
        $complemento->setLabel('Complemento:')
             ->setRequired(false)
             ->addFilter($stripTags)
             ->addFilter($trim)
             ->addValidator($validarTamanho)
             ->setDecorators(array($customDecorateInput));


        $this->addDisplayGroup(array(
                    $cep,
                    $logradouro,
                    $bairro,
                    $cidade,
                    $estado,
                    $numero,
                    $complemento,
                    ), 'Endereço', array('legend'=>'Endereço'));                      

        // $vendedor = new Zend_Form_Element_Text('usr_id_fk_carteira');
        // $vendedor->setLabel('Vendedor:(código)')
        //      ->setRequired(true)
        //      ->addFilter($stripTags)
        //      ->addFilter($trim)
        //      ->setDecorators(array($customDecorateInput));



        $vendedor = $this->createElement('select', 'select_vendedor', array(
            'label' => 'Vendedor',
            'elemName'=>'usr_id_fk_carteira',
            'required' => true,'class'=>'form-control',
        ));   



        // var_dump($this->_categoria->fetchAll());
        // exit;

        foreach ($this->_vendedor->fetchAll("usr_permissao='vendedor'","usr_id DESC") as $row) {
            $vendedor->addMultiOption($row['usr_id'], $row['usr_nome']);
        }
        
        $vendedor->setDecorators(array($customDecorateSelectVendedor));         

        if($identity->usr_permissao!="revendedor"){


            $revendedorInput = new Zend_Form_Element_Text('usr_id_fk_agregado');
            $revendedorInput->setLabel('Agregar ao Revendedor:(código)')
                 ->setRequired(false)
                 ->addFilter($stripTags)
                 ->addFilter($trim)
                 ->setDecorators(array($customDecorateInput));

         }
        

        $permissao   = new Zend_Form_Element('select_permissao', array(
            'elemName'=>'usr_permissao',
            'label'=>'Permissao',
            'type' =>'select',
            'required' => true,
            'multiOptions' => array(
                ''=>'Selecionea permissão',
                'administrador'=>'Administrador',
                'operador'=>'Operador',  
                'vendedor'=>'Vendedor',
                'revendedor'=>'Revendedor',
                'painel'=>'painel',  
            ),
            'decorators' => array($customDecorateSelectPermissao)
        ));

        if($identity->usr_permissao!="revendedor"){

                $usuario = new Zend_Form_Element_Text('usr_usuario');
                $usuario->setLabel('Usuário:')
                     ->setRequired(true)
                     ->addFilter($stripTags)
                     ->addFilter($trim)
                     ->addValidator($validarTamanho)
                     ->setDecorators(array($customDecorateInput));

                $senha = new Zend_Form_Element_Text('usr_senha');
                $senha->setLabel('Senha:')
                        ->setRequired(true)
                        ->addFilter($stripTags)
                        ->addFilter($trim)
                        ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                        ->setDecorators(array($customDecorateInput));
                
                
                $repetir = new Zend_Form_Element_Text('repeat-password');
                $repetir->setLabel('Repetir a senha:')
                        ->setRequired(true)
                        ->addFilter($stripTags)
                        ->addFilter($trim)
                        ->addValidator(new Zend_Validate_StringLength(array('min' => 6,'max' => 12)))
                        ->addValidator('identical', true, array('usr_senha'))
                        ->setDecorators(array($customDecorateInput));

                } 

                $desconto = new Zend_Form_Element_Text('usr_tabela');
                $desconto->setLabel('Desconto sem (%):')
                     ->addFilter($trim)
                     ->setDecorators(array($customDecorateInput));


                $submit   = new Zend_Form_Element('btn_enviar', array(
                    'elemName'=>'btn_enviar',
                    'label'=>'Enviar Dados',
                    'type' =>'submit',
                    'required' => false,
                    'decorators' => array($customDecorateButton),
                    'setAttrib'=>array('name','btn_enviar')
                )); 

                if($identity->usr_permissao!="revendedor"){
                $this->addDisplayGroup(array(
                            $desconto,
                            $usuario,
                            $senha,
                            $repetir,
                            $permissao,
                            ), 'Acesso', array('legend'=>'Acesso ao CRM / Desconto')); 

                }

                if($identity->usr_permissao!="revendedor"){
                $this->addDisplayGroup(array(
                            $vendedor,
                            $revendedorInput,                    
                            $submit
                            ), 'Interno', array('legend'=>'Interno')); 
                }

                $this->setAttrib('id','form-usuario');


                $this->addElements(array(
                    @$vendedor,
                    $submit,
                ));
        
    }


}

