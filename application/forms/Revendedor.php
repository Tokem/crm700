<?php

class Application_Form_Revendedor extends Zend_Form
{

    public function init()
    {
         /*validadores*/
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
              ->setRequired(true)
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
             "Acre"=>"Acre",
             "Alagoas"=>"Alagoas", 
             "Amazonas"=>"Amazonas", 
             "Amapá"=>"Amapá",
             "Bahia"=>"Bahia",
             "Ceará"=>"Ceará",
             "Distrito Federal"=>"Distrito Federal",
             "Espírito Santo"=>"Espírito Santo",
             "Goiás"=>"Goiás",
             "Maranhão"=>"Maranhão",
             "Mato Grosso"=>"Mato Grosso",
             "Mato Grosso do Sul"=>"Mato Grosso do Sul",
             "Minas Gerais"=>"Minas Gerais",
             "Pará"=>"Pará",
             "Paraíba"=>"Paraíba",
             "Paraná"=>"Paraná",
             "Pernambuco"=>"Pernambuco",
             "Piauí"=>"Piauí",
             "Rio de Janeiro"=>"Rio de Janeiro",
             "Rio Grande do Norte"=>"Rio Grande do Norte",
             "Rondônia"=>"Rondônia",
             "Rio Grande do Sul"=>"Rio Grande do Sul",
             "Roraima"=>"Roraima",
             "Santa Catarina"=>"Santa Catarina",
             "Sergipe"=>"Sergipe",
             "São Paulo"=>"São Paulo",
             "Tocantins"=>"Tocantins"),
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
             ->setRequired(true)
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


        if($identity->usr_permissao!="revendedor"){


            $revendedorInput = new Zend_Form_Element_Text('usr_id_fk_agregado');
            $revendedorInput->setLabel('Agregar ao Revendedor:(código)')
                 ->setRequired(false)
                 ->addFilter($stripTags)
                 ->addFilter($trim)
                 ->setDecorators(array($customDecorateInput));

         }
        
        if($identity->usr_permissao!="revendedor"){

                $usuario = new Zend_Form_Element_Text('usr_usuario');
                $usuario->setLabel('Usuário:')
                     ->setRequired(true)
                     ->addFilter($stripTags)
                     ->addFilter($trim)
                     ->addValidator($validarTamanho)
                     ->setDecorators(array($customDecorateInput));;

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
                            $usuario,
                            $senha,
                            $repetir,
                            ), 'Acesso', array('legend'=>'Acesso ao CRM')); 

                }

                if($identity->usr_permissao!="revendedor"){
                $this->addDisplayGroup(array(
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

