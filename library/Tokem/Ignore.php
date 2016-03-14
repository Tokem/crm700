<?php

class Tokem_Ignore
{
    
    public function ignore($form){
        
        $form->getElement('usr_telefone')->setRequired(false);
        $form->getElement('select_pergunta')->setRequired(false);
        $form->getElement('que_resposta')->setRequired(false);
        $form->getElement('fis_rg')->setRequired(false);
        $form->getElement('fis_cpf')->setRequired(false);
        $form->getElement('fis_data_nasc')->setRequired(false);
        $form->getElement('fis_profissao')->setRequired(false);
        $form->getElement('fis_rg')->setRequired(false);  
        $form->getElement('fis_ocupacao')->setRequired(false);  

        // endereço
        $form->getElement('end_logradouro')->setRequired(false);
        $form->getElement('end_cidade')->setRequired(false);
        $form->getElement('end_bairro')->setRequired(false);
        $form->getElement('select_estado')->setRequired(false);
        $form->getElement('end_cep')->setRequired(false);
        $form->getElement('end_numero')->setRequired(false);
        $form->getElement('end_complemento')->setRequired(false);
        $form->getElement('select_vendedor')->setRequired(false);
    
    }
    
}