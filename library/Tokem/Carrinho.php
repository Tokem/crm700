<?php

/*@author: RODOLFO ALMEIDA*/

class Tokem_Carrinho  {


  protected $_pedido = array();
  protected $_global = array();
  protected $_codigos = array();
  protected $_authNamespace;



  function __construct(){
    $this->_authNamespace = new Zend_Session_Namespace('Carrinho');
  }


  function verificarAtualizar($dados){

    foreach ($dados as $key => $value) {

                foreach ($value as $a => $b) {
                    if(empty($b)){
                       unset($value[$a]);
                    }
                }            
                        
                foreach ($value['numeros'] as $chave => $valor) {
                    if(empty($valor)){
                        unset($value['numeros'][$chave]);
                        if(empty($value['numeros'])){
                            unset($value['numeros']);
                        }
                    }
                }

                $aux = count($value);
                if($aux > 4){                    
                    $this->_global[$value['id']] = $value;
                }
    }

    /**
      Faz A verificação
    **/
    foreach ($this->_global as $c => $d) {
        
        
        $indice2 = in_array($c, $this->_authNamespace->carrinho);
        $indice3 = array_search($c, $this->_authNamespace->carrinho);

        //Cria uma lista com os codigos dos produtos;
        foreach ($this->_authNamespace->carrinho as $a => $b) {
          $this->_codigos[]=$a;
        }

        //var_dump($this->_codigos);
        //echo $c;
        //exit;

        $indice = in_array($c, $this->_codigos);

        /**
          Atualiza
        **/
        if($indice){

          foreach ($this->_global as $m => $n) {
            
            foreach ($n["numeros"] as $j => $i) {

              $numero = array_key_exists($j, $this->_authNamespace->carrinho[$c]["numeros"]);

              if($numero){
                /**
                Atualiza a quantidade do numero do calçado pedido
                **/

                $this->_authNamespace->carrinho[$c]["numeros"][$j]+=$i;
                                
              }else{
                /**
                  se não existe o numero adiciona ao final do array
                **/
                $this->_authNamespace->carrinho[$c]["numeros"][$j] = $i; 
              }
            }
            
          }          
        }else{
          /**
          Se não existe adiciona ao final do array
         **/

          foreach ($this->_global as $c => $d){            
            $this->_authNamespace->carrinho[$c]= $d;
          }

        }
    }

    
  }


  function adicionar($dados){

    foreach ($dados as $key => $value) {

                foreach ($value as $a => $b) {
                    if(empty($b)){
                       unset($value[$a]);
                    }
                }            
                        
                foreach ($value['numeros'] as $chave => $valor) {
                    if(empty($valor)){
                        unset($value['numeros'][$chave]);
                        if(empty($value['numeros'])){
                            unset($value['numeros']);
                        }
                    }
                }

                $aux = count($value);
                if($aux > 4){                    
                    $this->_pedido[$value['id']] = $value;
                }
    }

    $this->_authNamespace->carrinho = $this->_pedido;

  }


  function excluirItem($id,$numero){
                    
                    $authNamespace = new Zend_Session_Namespace('Carrinho');                    
                    $exists = array_key_exists($id, $authNamespace->carrinho);
                    if($exists){
                      // echo $numero;
                      // echo $this->_authNamespace->carrinho[$id]["numeros"][$numero];
                      //   exit;
                      $qtd =count($this->_authNamespace->carrinho[$id]["numeros"])."<br/>";

                      if($qtd>1){
                        unset($this->_authNamespace->carrinho[$id]["numeros"][$numero]);                                            
                      }

                      if($qtd==1){
                        unset($this->_authNamespace->carrinho[$id]);                                            
                      }
                      
                      return true;
                      exit;
                    }else{
                       return false; 
                       exit; 
                    }                    

  }



  function somarItem($id,$numero){
                    
                    $authNamespace = new Zend_Session_Namespace('Carrinho');                    
                    $exists = array_key_exists($id, $authNamespace->carrinho);
                    if($exists){
                      $qtd = 1;
                      $this->_authNamespace->carrinho[$id]["numeros"][$numero]+=$qtd;
                      
                      return true;
                      exit;
                    }else{
                       return false; 
                       exit; 
                    }                    

  }

  function subtrairItem($id,$numero){
                    
                    $authNamespace = new Zend_Session_Namespace('Carrinho');                    
                    $exists = array_key_exists($id, $authNamespace->carrinho);
                    if($exists){
                      $qtd = 1;
                      if($this->_authNamespace->carrinho[$id]["numeros"][$numero]>1){
                        $this->_authNamespace->carrinho[$id]["numeros"][$numero]-=$qtd;  
                      }
                      
                      return true;
                      exit;
                    }else{
                       return false; 
                       exit; 
                    }                    

  }




}