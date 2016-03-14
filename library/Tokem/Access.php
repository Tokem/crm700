<?php

class Tokem_Access
{
       
    public function  permissions(){
        
          /*Adiciona os papeis */ 
        $acl = new Zend_Acl();
        $acl->addRole(new Zend_Acl_Role('administrador'));   
        $acl->addRole(new Zend_Acl_Role('revendedor'));
        $acl->addRole(new Zend_Acl_Role('vendedor'));   
        $acl->addRole(new Zend_Acl_Role('operador'));   
        $acl->addRole(new Zend_Acl_Role('usuario'));   
        
        
        /*Adicionaos recursos ou paginas que podem ser vistas*/
        $acl->addResource('index')
        ->addResource('pedidos')
        ->addResource('agregados')
        ->addResource('usuarios')
        ->addResource('premiacoes')
        ->addResource('notificacoes')
        ->addResource('ajuda')
        ->addResource('novidades')
        ->addResource('negocios')
        ->addResource('produto')
        ->addResource('categoria')
        ->addResource('perfil');
        
        //$acl->deny('administrador','cliente','operador');
        
        try {
            //$acl->allow(array('administrador','operador','cliente','social'));
            $acl->allow('administrador',array('index','ajuda','negocios','novidades','pedidos','perfil','premiacoes','usuarios','notificacoes','produto','categoria'));
            $acl->allow('revendedor',array('index','ajuda','negocios','novidades','pedidos','perfil','premiacoes','notificacoes','usuarios','agregados',));
            $acl->allow('vendedor',array('index','ajuda','negocios','novidades','pedidos','perfil','premiacoes','notificacoes','usuarios'));
            
            
        } catch (Exception $exc) {
            echo "<pre>".$exc->getMessage()."</pre>";
        }
        
       Zend_Registry::set('acl', $acl);
        
    }
   
}
