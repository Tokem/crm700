<?php

class UsuariosController extends Tokem_ControllerBase
{

    protected $_usuarios = null;
    protected $_pFisica = null;
    protected $_pergunta = null;
    protected $_endereco = null;
    protected $_notificacao = null;
    protected $_identity = null;
    protected $_permissaoUsuario = null;

    protected $_dbAdapter = null;


    public function init()
    {   
        parent::init();

        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();        
        $this->_usuarios = new Application_Model_Usuarios();
        $this->_pFisica = new Application_Model_PessoaFisica();
        $this->_pergunta = new Application_Model_Questionario();
        $this->_endereco = new Application_Model_Enderecos();
        $this->_notificacao = new Application_Model_Notificacao();
        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        $this->_identity = $identity;

        
    }

    public function indexAction()
    {


        if($this->_identity->usr_permissao=="revendedor"){
            $this->_forward('index', 'agregados', null,null);
        }

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');

        $list = $this->_usuarios->fetchAll(null,"usr_id DESC");      
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;

    }

    public function agregadosAction()
    {


        // if($this->_identity->usr_permissao=="revendedor"){
        //     $this->_forward('index', 'agregados', null,null);
        // }

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');

        $id = $this->getRequest()->getParam('id');

        $usuario = $this->_usuarios->fetchRow("usr_id=$id",null);      
        $list = $this->_usuarios->fetchAll("usr_id_fk_agregado=$id","usr_id DESC");      
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;
        $this->view->nome = $usuario->usr_nome;

    }

    public function carteiraAction()
    {


        if($this->_identity->usr_permissao=="revendedor"){
            $this->_forward('index', 'agregados', null,null);
        }

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');

        $id = $this->getRequest()->getParam('id');

        $usuario = $this->_usuarios->fetchRow("usr_id=$id",null);      
        $list = $this->_usuarios->fetchAll("usr_id_fk_carteira=$id","usr_id DESC");      
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;
        $this->view->nome = $usuario->usr_nome;

    }


    public function vendedoresAction()
    {


        if($this->_identity->usr_permissao=="revendedor"){
            $this->_forward('index', 'agregados', null,null);
        }

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');

        $list = $this->_usuarios->fetchAll("usr_permissao='vendedor' ","usr_id DESC");      
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;

    }

    public function revendedoresAction()
    {


        if($this->_identity->usr_permissao=="revendedor"){
            $this->_forward('index', 'agregados', null,null);
        }

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');

        $list = $this->_usuarios->fetchAll("usr_permissao='revendedor'","usr_id DESC");      
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;

    }


    public function cadastrarAction()
    {


        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/datatable/js/datatables.min.js');
        
        $this->view->headLink()->appendStylesheet('/crm700/public/assets/css/bootstrap-datepicker.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/themes/default.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/themes/semantic.min.css');
        
    
        $this->view->headScript()->appendFile($this->_baseUrl . '/assets/js/bootstrap-datepicker.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/vanilla-masker/vanilla-masker.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/jquery-pstrength/jquery.pstrength-min.1.2.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');
        
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');

        switch ($this->_identity->usr_permissao) {
            case 'vendedor':
                $form = new Application_Form_Revendedor();
                $this->_permissaoUsuario = "revendedor";
                break;
            
            default:
                $form = new Application_Form_Usuario();
                break;
        }

        $form->setAction($this->_helper->url('cadastrar'));
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();

        $vendedores = $this->_usuarios->fetchAll("usr_permissao = 'vendedor'","usr_id DESC");
        $this->view->lista = $vendedores;

        if(isset($dados["select_permissao"])){
            $this->_permissaoUsuario = $dados["select_permissao"];
        }else{
            $this->_permissaoUsuario = "revendedor";
        }

        if(@$this->_permissaoUsuario=="vendedor" || @$this->_permissaoUsuario=="administrador" ){
                $ignorar = new Tokem_Ignore();
                $ignorar->ignore($form);
        }

        if (!@$dados['usr_senha'] && $this->_identity->usr_permissao!="revendedor") {
            $form->getElement('usr_senha')->setRequired(false);
            $form->getElement('repeatpassword')->setRequired(false);
        }
        
        if ($request->isPost() && $form->isValid($request->getPost())) {
            
            $this->_dbAdapter->beginTransaction();

            if(@$this->_permissaoUsuario!="vendedor"){
               $aux = explode('/', $dados['fis_data_nasc']);
               $dataNasc = $aux[2] . "-".$aux[1]."-".$aux[0];         
            }else{
               $dataNasc = null; 
            }
            


            switch ($this->_identity->usr_permissao) {
                case "revendedor":
                    $agregado = @$dados["usr_id_fk_agregado"];
                    $permissao  = "revendedor";
                    $senha = null;
                    $carteira = $dados["usr_id_fk_carteira"];
                    break;
                case "vendedor":
                    $carteira = $this->_identity->usr_id;
                    $permissao  = "revendedor";
                    $senha = $dados["usr_senha"];
                    $agregado = $dados["usr_id_fk_agregado"];
                    break;
                 case "administrador":
                    $agregado = @$dados["usr_id_fk_agregado"];
                    $permissao  = @$dados["select_permissao"];
                    $senha = @$dados["usr_senha"];
                    $carteira = @$dados["usr_id_fk_carteira"];
                    break;           
                
            }


                    $usuario = array(
                        "usr_nome"=>$dados["usr_nome"],
                        "usr_usuario"=>@$dados["usr_usuario"],
                        "usr_permissao"=>$permissao,
                        "usr_senha"=>$senha,
                        "usr_foto"=>@$dados["usr_foto"],
                        "usr_telefone"=>$dados["usr_telefone"],
                        "usr_email"=>$dados["usr_email"],
                        "usr_tabela"=>@$dados["usr_tabela"],
                        "usr_celular"=>$dados["usr_celular"],
                        "usr_vende"=>@$dados["select_pergunta"],
                        "usr_vende_resposta"=>$dados["que_resposta"],
                        "usr_id_fk_carteira"=>@$carteira,
                        "usr_id_fk_agregado"=>$agregado
                    );


                        try {
                            $lastInsert = $this->_usuarios->insert($usuario);    
                        } catch (Zend_Db_Exception $e) {
                            //echo $e->getMessage();
                            $this->_dbAdapter->rollBack();
                            //exit;

                            $flashMessenger = $this->_helper->FlashMessenger;   
                            $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                            </div>');
                            
                            $this->_helper->redirector('index');     
                            exit;
                        }
             

                    $pessoaFisica = array(
                        "fis_rg"=>@$dados["fis_rg"],
                        "fis_cpf"=>@$dados["fis_cpf"],
                        "fis_data_nasc"=>@$dataNasc,
                        "fis_ocupacao"=>@$dados["fis_ocupacao"],
                        "fis_profissao"=>@$dados["fis_profissao"],
                        "usr_id_fk"=>@$lastInsert,
                    );


                        try {
                            $this->_pFisica->insert($pessoaFisica);    
                        } catch (Zend_Db_Exception $e) {
                            echo $e->getMessage();
                            $this->_dbAdapter->rollBack();
                            exit;

                            $flashMessenger = $this->_helper->FlashMessenger;   
                            $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                            </div>');
                            
                            $this->_helper->redirector('index');     
                            exit;
                        }


                    $endereco = array(
                        "end_logradouro"=>@$dados["end_logradouro"],
                        "end_cidade"=>@$dados["end_cidade"],
                        "end_bairro"=>@$dados["end_bairro"],
                        "end_cidade"=>@$dados["end_cidade"],
                        "end_estado"=>@$dados["select_estado"],
                        "end_cep"=>@$dados["end_cep"],
                        "end_numero"=>@$dados["end_numero"],
                        "end_complemento"=>@$dados["end_complemento"],
                        "usr_id_fk"=>$lastInsert,
                    );              


                        try {
                            $this->_endereco->insert($endereco);

                        } catch (Zend_Db_Exception $e) {
                            echo $e->getMessage();
                            $this->_dbAdapter->rollBack();
                            exit;

                            $flashMessenger = $this->_helper->FlashMessenger;   
                            $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                            </div>');
                            
                            $this->_helper->redirector('index');     
                            exit;
                        }

    

                         try {
                                if(isset($dados["usr_id_fk_carteira"])&&$dados["usr_id_fk_carteira"]!=0 ){

                                    $notificacao = array("not_tipo"=>"MSG Sistema",
                                        "not_mensagem"=>"Você recebeu um novo cadastro",
                                        "not_link"=>$this->_baseUrl."/usuarios/ver/id/".$lastInsert,
                                        "usr_id_fk"=>$dados["usr_id_fk_carteira"],
                                        "not_usr_nome"=>$dados["usr_nome"],
                                        "not_permissao"=>$dados["select_permissao"]);

                                    $this->_notificacao->insert($notificacao);

                                }

                            } catch (Zend_Db_Exception $e) {
                                
                                    $flashMessenger = $this->_helper->FlashMessenger;   
                                    $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                                    </div>');
                                    
                                    $this->_helper->redirector('index');     
                                    exit;
                            }   


            $flashMessenger = $this->_helper->FlashMessenger;   
            $flashMessenger->addMessage('
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Sucesso</strong> - Tudo ocorreu bem!
                        </div>
                    ');
                              

            $this->_dbAdapter->commit();
            switch ($this->_identity->usr_permissao) {
                case "vendedor":
                      $this->_redirect('/carteira/index');
                    break;
                case "revendedor":
                      $this->_redirect('/agregados/index');
                    break;
                case "administrador":
                      $this->_helper->redirector('index');
                    break;        
                
            }
            

        }else{
            @$this->view->estado = $dados["select_estado"];
            @$this->view->permissao =  $dados["select_permissao"];
            @$this->view->pergunta =  $dados["select_pergunta"];
            
        }
        
        $this->view->form = $form;
    }

    
    public function editarAction(){

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
            
        $this->view->headLink()->appendStylesheet('/crm700/public/assets/css/bootstrap-datepicker.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/themes/default.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/themes/semantic.min.css');
        
    
        $this->view->headScript()->appendFile($this->_baseUrl . '/assets/js/bootstrap-datepicker.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/vanilla-masker/vanilla-masker.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/jquery-pstrength/jquery.pstrength-min.1.2.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');
        
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');

        
        switch ($this->_identity->usr_permissao) {
            case 'vendedor':
                $form = new Application_Form_Revendedor();
                $this->_permissaoUsuario = "revendedor";
                break;
            
            default:
                $form = new Application_Form_Usuario();
                break;
        }

        $form->setAction($this->_helper->url('editar'));
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();

        $id = $this->getRequest()->getParam('id');
        $dados = $this->getRequest()->getParams();
        $form->setAction($this->_helper->url('editar/id/' . $id));
        
        /* Obtem um unico usuário através do id passado */
        $usuario = $this->_usuarios->find($id)->current();
        $fisica = $this->_pFisica->find($id)->current();
        $endereco = $this->_endereco->find($id)->current();

        if(@!empty($fisica->fis_data_nasc)&&$fisica->fis_data_nasc!="00/00/0000"){
            $aux = explode('-', $fisica->fis_data_nasc);
            $data = $aux[2] . "/".$aux[1]."/".$aux[0];    
        }elseif(@$fisica->fis_data_nasc=="00/00/0000"){
            $data = null;
        }else{
            $data = null;
        }
        

        if($usuario->usr_id_fk_carteira==0){
            $carteira=null;}
            else{$carteira=$usuario->usr_id_fk_carteira;
        }
        if($usuario->usr_id_fk_agregado==0){
            $agregado=null;}
            else{$agregado=$usuario->usr_id_fk_agregado;}

        //echo $carteira;
        //exit;

        $usuarioForm = array(
            "usr_nome"=>$usuario->usr_nome,
            "usr_usuario"=>$usuario->usr_usuario,
            "fis_profissao"=>@$fisica->fis_profissao,
            "fis_ocupacao"=>@$fisica->fis_ocupacao,
            "fis_data_nasc"=>@$data,
            "fis_cpf"=>@$fisica->fis_cpf,
            "fis_rg"=>@$fisica->fis_rg,
            "usr_email"=>@$usuario->usr_email,
            "usr_telefone"=>@$usuario->usr_telefone,
            "usr_senha"=>@$usuario->usr_senha,
            "repeatpassword"=>@$usuario->usr_senha,
            "usr_celular"=>@$usuario->usr_celular,
            "usr_tabela"=>@$usuario->usr_tabela,
            "select_pergunta"=>@$usuario->usr_vende,
            "que_resposta"=>@$usuario->usr_vende_resposta,
            "usr_permissao"=>@$usuario->usr_permissao,
            "end_cep"=>@$endereco->end_cep,
            "end_logradouro"=>@$endereco->end_logradouro,
            "end_bairro"=>@$endereco->end_bairro,
            "end_cidade"=>@$endereco->end_cidade,
            "end_numero"=>@$endereco->end_numero,
            "end_complemento"=>@$endereco->end_complemento,
            "usr_id_fk_carteira"=>$carteira,
            "usr_id_fk_agregado"=>$agregado);

        @$this->view->estado = $endereco->end_estado;
        @$this->view->pergunta  = $usuario->usr_vende;
        @$this->view->permissao =  $usuario->usr_permissao;
        @$this->view->usr_id =  $usuario->usr_id;
        @$this->view->usr_ativo =  $usuario->usr_ativo;

        $form->populate($usuarioForm);
        $request = $this->getRequest();

         if(isset($dados["usr_id_fk_carteira"])){
                $carteira = $dados["usr_id_fk_carteira"];
                $form->getElement('usr_id_fk_carteira')->setValue($carteira);
         }
         // else{
         //        $carteira = $this->_identity->usr_id;
         //        $form->getElement('usr_id_fk_carteira')->setValue($carteira);
         // }

         // var_dump(empty($dados["usr_senha"]));
         // exit;

         if(empty($dados["usr_senha"])){
            $form->getElement('usr_senha')->setRequired(true);
            $form->getElement('repeatpassword')->setRequired(true);
            $senha = $usuario->usr_senha;
         }else{
            $senha = $dados["usr_senha"];
         }


        if ($request->isPost() && $form->isValid($request->getPost())) {


            $this->_dbAdapter->beginTransaction();

            try {


                switch ($this->_identity->usr_permissao) {
                case "revendedor":
                    $agregado = @$dados["usr_id_fk_agregado"];
                    $permissao  = "revendedor";
                    $senha = null;
                    $carteira = $dados["usr_id_fk_carteira"];
                    break;
                case "vendedor":
                    $carteira = $this->_identity->usr_id;
                    $permissao  = "revendedor";
                    $senha = $dados["usr_senha"];
                    $agregado = $dados["usr_id_fk_agregado"];
                    break;
                 case "administrador":
                    $agregado = @$dados["usr_id_fk_agregado"];
                    $permissao  = @$dados["select_permissao"];
                    $senha = @$dados["usr_senha"];
                    $carteira = @$dados["usr_id_fk_carteira"];
                    break;           
                
                }

                $aux = explode('/', $dados['fis_data_nasc']);
                $dataNasc = $aux[2] . "-".$aux[1]."-".$aux[0];        

                
                $fisica->fis_profissao = $dados["fis_profissao"];
                $fisica->fis_ocupacao = $dados["fis_ocupacao"];
                $fisica->fis_data_nasc =$dataNasc;
                $fisica->fis_cpf=$dados["fis_cpf"];
                $fisica->fis_rg=$dados["fis_rg"];

                $fisica->save();


                if($dados["usr_senha"]){
                   $usuario->usr_senha = $dados["usr_senha"];
                }



                $usuario->usr_nome =$dados["usr_nome"];
                $usuario->usr_senha =$senha;
                $usuario->usr_usuario =$dados["usr_usuario"];
                $usuario->usr_email =$dados["usr_email"];
                $usuario->usr_telefone =$dados["usr_telefone"];
                $usuario->usr_celular =$dados["usr_celular"];
                $usuario->usr_vende =$dados["select_pergunta"];
                $usuario->usr_vende_resposta =$dados["que_resposta"];
                $usuario->usr_permissao =$permissao;
                $usuario->usr_id_fk_carteira =$carteira;
                $usuario->usr_id_fk_agregado =$agregado;


                $endereco->end_cep =$dados["end_cep"];
                $endereco->end_logradouro =$dados["end_logradouro"];
                $endereco->end_bairro =$dados["end_bairro"];
                $endereco->end_cidade= $dados["end_cidade"];
                $endereco->end_numero =$dados["end_numero"];
                $endereco->end_complemento =$dados["end_complemento"];

                $endereco->save();
                

                if ($dados['usr_senha']) {
                    $senha = $dados['usr_senha'];
                    $usuario->usr_senha = $dados['usr_senha'];
                }



                $usuario->save();
                
                $this->_dbAdapter->commit();

                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('
                            <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Sucesso</strong> - Tudo ocorreu bem!
                            </div>
                        ');
            

            } catch (Zend_Db_Exception $e) {
                
                // echo $e->getMessage();
                // exit;
                
                $this->_dbAdapter->rollBack();
                $flashMessenger = $this->_helper->FlashMessenger;   
                            $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                            </div>');
                
                $this->_helper->redirector('index');
            }


            try {
                                    

                            if(isset($dados["usr_id_fk_carteira"])&&$dados["usr_id_fk_carteira"]!=0){

                                $notificacao = array("not_tipo"=>"MSG Sistema",
                                    "not_mensagem"=>"Você recebeu um novo cadastro",
                                    "not_link"=>$this->_baseUrl."/usuarios/ver/id/".$usuario->usr_id,
                                    "usr_id_fk"=>$dados["usr_id_fk_carteira"],
                                    "not_usr_nome"=>$dados["usr_nome"],
                                    "not_permissao"=>$dados["select_permissao"]);

                                $this->_notificacao->insert($notificacao);

                            }

                            switch ($this->_identity->usr_permissao) {
                                case "vendedor":
                                      $this->_redirect('/carteira/index');
                                    break;
                                case "revendedor":
                                      $this->_redirect('/agregados/index');
                                    break;
                                case "administrador":
                                      $this->_helper->redirector('index');
                                    break;        
                                
                            }

                            } catch (Zend_Db_Exception $e) {
                                echo $e->getMessage;
                                exit;
                            }   

        }

        $this->view->formUsuario = $form;    
        $this->view->form = $form;

    }

    public function perfilAction(){

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
            
        $this->view->headLink()->appendStylesheet('/crm700/public/assets/css/bootstrap-datepicker.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/themes/default.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/themes/semantic.min.css');
        
    
        $this->view->headScript()->appendFile($this->_baseUrl . '/assets/js/bootstrap-datepicker.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/vanilla-masker/vanilla-masker.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/jquery-pstrength/jquery.pstrength-min.1.2.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');
        
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');

        
        $form = new Application_Form_Perfil();

        
        $form->setAction($this->_helper->url('editar'));
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();

        $id = $this->getRequest()->getParam('id');
        $dados = $this->getRequest()->getParams();
        $form->setAction($this->_helper->url('editar/id/' . $id));
        
        /* Obtem um unico usuário através do id passado */
        $usuario = $this->_usuarios->find($id)->current();
        $fisica = $this->_pFisica->find($id)->current();
        $endereco = $this->_endereco->find($id)->current();

        if(!empty($fisica->fis_data_nasc)&&$fisica->fis_data_nasc!="00/00/0000"){
            $aux = explode('-', $fisica->fis_data_nasc);
            $data = $aux[2] . "/".$aux[1]."/".$aux[0];    
        }elseif($fisica->fis_data_nasc=="00/00/0000"){
            $data = null;
        }else{
            $data = null;
        }
        

        if($usuario->usr_id_fk_carteira==0){$carteira=null;}else{$carteira=$usuario->usr_id_fk_carteira;}
        if($usuario->usr_id_fk_agregado==0){$agregado=null;}else{$agregado=$usuario->usr_id_fk_agregado;}

        $usuarioForm = array(
            "usr_nome"=>$usuario->usr_nome,
            "usr_usuario"=>$usuario->usr_usuario,
            "fis_profissao"=>$fisica->fis_profissao,
            "fis_ocupacao"=>$fisica->fis_ocupacao,
            "fis_data_nasc"=>$data,
            "fis_cpf"=>$fisica->fis_cpf,
            "fis_rg"=>$fisica->fis_rg,
            "usr_email"=>$usuario->usr_email,
            "usr_telefone"=>$usuario->usr_telefone,
            "usr_celular"=>$usuario->usr_celular,
            "select_pergunta"=>$usuario->usr_vende,
            "que_resposta"=>$usuario->usr_vende_resposta,
            "usr_permissao"=>$usuario->usr_permissao,
            "end_cep"=>@$endereco->end_cep,
            "end_logradouro"=>@$endereco->end_logradouro,
            "end_bairro"=>@$endereco->end_bairro,
            "end_cidade"=>@$endereco->end_cidade,
            "end_numero"=>@$endereco->end_numero,
            "end_complemento"=>@$endereco->end_complemento,
            "usr_id_fk_carteira"=>@$carteira,
            "usr_id_fk_agregado"=>$agregado);

        @$this->view->estado = $endereco->end_estado;
        @$this->view->pergunta  = $usuario->usr_vende;
        @$this->view->permissao =  $usuario->usr_permissao;
        @$this->view->usr_id =  $usuario->usr_id;
        @$this->view->usr_ativo =  $usuario->usr_ativo;

        $form->populate($usuarioForm);
        
        if (!@$dados['usr_senha']) {
            $form->getElement('usr_senha')->setRequired(false);
            $form->getElement('repeatpassword')->setRequired(false);
        }

        $this->view->formUsuario = $form;    
        $this->view->form = $form;

    }

    public function procurarUsuarioAction()
    {

    
        $dados = $this->getRequest()->getParams();
        $usr = $dados["usr_usuario"];

        $usuario = $this->_usuarios->fetchRow("usr_usuario='$usr'");

        
        if(isset($usuario->usr_usuario)){
            echo json_encode( $array = array("mensagem"=>"Usuário <span style='color:red'>'$usr'</span> indisponível","disable"=>"1"));
        }else{
            echo json_encode( $array = array("mensagem"=>"ok"));
        }
        

        exit;
        //end
    }

    public function procurarVendedorAction()
    {

    
        $dados = $this->getRequest()->getParams();
        $id = $dados["usr_id_fk_carteira"];
        $vendedor = $this->_usuarios->fetchRow("usr_id='$id'");
        
        if(isset($vendedor->usr_id) && $vendedor->usr_permissao=="vendedor"){
            echo json_encode( $array = array("mensagem"=>"ok"));
        }
        else if(!isset($vendedor->usr_id)){
            echo json_encode($array=array("mensagem"=>"Código <span style='color:red'>'$id'</span> não encontrado","disable"=>"1"));
        }else if (isset($vendedor->usr_id) && $vendedor->usr_permissao!="vendedor") {
            echo json_encode($array=array("mensagem"=>"Código <span style='color:red'>'$id'</span> não pertence a um Vendedor","disable"=>"1"));
        }

        exit;
        //end
    }


    // public function verificarVendedorAction()
    // {

    
    //     $dados = $this->getRequest()->getParams();
    //     $id = $dados["usr_id"];
    //     $usuario = $this->_usuarios->fetchRow("usr_id='$id'");
        
    //     if(isset($usuario->usr_id_fk_carteira)&&$usuario->usr_id_fk_carteira!=0){
    //         echo json_encode( $array = array("mensagem"=>"ok"));
    //     }else{
    //         echo json_encode($array=array("mensagem"=>"Código <span style='color:red'>'Você precisa adicionar o código do vendedor!'</span>"));
    //     }

    //     exit;
    //     //end
    // }


    public function procurarRevendedorAction()
    {


    
        $dados = $this->getRequest()->getParams();
        $id = $dados["usr_id_fk_agregado"];
        $vendedor = $this->_usuarios->fetchRow("usr_id='$id'");
        
        if(isset($vendedor->usr_id) && $vendedor->usr_permissao=="revendedor"){
            echo json_encode( $array = array("mensagem"=>"ok"));
        }
        else if(!isset($vendedor->usr_id)){
            echo json_encode($array=array("mensagem"=>"Código <span style='color:red'>'$id'</span> não encontrado","disable"=>"1"));
        }else if (isset($vendedor->usr_id) && $vendedor->usr_permissao!="revendedor") {
            echo json_encode($array=array("mensagem"=>"Código <span style='color:red'>'$id'</span> não pertence a um Revendedor","disable"=>"1"));
        }

        exit;
        //end
    }


    public function ativarAction()
    {

        
        $dados = $this->getRequest()->getParams();
        $id = $dados["usr_id"];
        $ativo = $dados["usr_ativo"];
        $usuario = $this->_usuarios->fetchRow("usr_id='$id'");
        

        // if(is_null($usuario->usr_id_fk_carteira) || $usuario->usr_id_fk_carteira==0 && $usuario->usr_permissao=="revendedor"){
        //     echo json_encode( $array = array("mensagem"=>"sem código"));
        // }else{

              if($ativo=="true"){
                $ativo =1;
               }else{
                $ativo =0;
               }


               try {
                $usuario->usr_ativo = $ativo;
                $usuario->save();
                echo 1;
                exit;   
               } catch (Zend_Db_Exception $e) {
                   echo 0;
                   exit;   
               }
       // }

        exit;
        //end
    }


        public function verAction(){

        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
            
        $this->view->headLink()->appendStylesheet('/crm700/public/assets/css/bootstrap-datepicker.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/themes/default.min.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/themes/semantic.min.css');
        
    
        $this->view->headScript()->appendFile($this->_baseUrl . '/assets/js/bootstrap-datepicker.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/vanilla-masker/vanilla-masker.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/jquery-pstrength/jquery.pstrength-min.1.2.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');
        
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');

        
        $form = new Application_Form_Usuario();
        $form->setAction($this->_helper->url('editar'));
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();

        $id = $this->getRequest()->getParam('id');
        $dados = $this->getRequest()->getParams();

        $form->setAction($this->_helper->url('editar/id/' . $id));

        
        /* Obtem um unico usuário através do id passado */
        $usuario = $this->_usuarios->find($id)->current();
        $fisica = $this->_pFisica->find($id)->current();
        $endereco = $this->_endereco->find($id)->current();

        $aux = explode('-', $fisica->fis_data_nasc);
        $data = $aux[2] . "/".$aux[1]."/".$aux[0];

        if($usuario->usr_id_fk_carteira==0){$carteira=null;}else{$carteira=$usuario->usr_id_fk_carteira;}
        if($usuario->usr_id_fk_agregado==0){$agregado=null;}else{$agregado=$usuario->usr_id_fk_agregado;}

        $usuarioForm = array(
            "usr_nome"=>$usuario->usr_nome,
            "usr_usuario"=>$usuario->usr_usuario,
            "fis_profissao"=>$fisica->fis_profissao,
            "fis_ocupacao"=>$fisica->fis_ocupacao,
            "fis_data_nasc"=>$data,
            "fis_cpf"=>$fisica->fis_cpf,
            "fis_rg"=>$fisica->fis_rg,
            "usr_email"=>$usuario->usr_email,
            "usr_senha"=>$usuario->usr_senha,
            "repeatpassword"=>$usuario->usr_senha,
            "usr_telefone"=>$usuario->usr_telefone,
            "usr_celular"=>$usuario->usr_celular,
            "select_pergunta"=>$usuario->usr_vende,
            "que_resposta"=>$usuario->usr_vende_resposta,
            "usr_permissao"=>$usuario->usr_permissao,
            "end_cep"=>$endereco->end_cep,
            "end_logradouro"=>$endereco->end_logradouro,
            "end_bairro"=>$endereco->end_bairro,
            "end_cidade"=>$endereco->end_cidade,
            "end_numero"=>$endereco->end_numero,
            "end_complemento"=>$endereco->end_complemento,
            "usr_id_fk_carteira"=>$carteira,
            "usr_id_fk_agregado"=>$agregado);

        @$this->view->estado = $endereco->end_estado;
        @$this->view->pergunta = $usuario->usr_vende;
        @$this->view->permissao =  $usuario->usr_permissao;
        @$this->view->usr_id =  $usuario->usr_id;
        @$this->view->usr_ativo =  $usuario->usr_ativo;

        $form->populate($usuarioForm);
        
        $this->view->formUsuario = $form;    
        $this->view->form = $form;

    }

    public function excluirAction(){

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $this->_dbAdapter->beginTransaction();
            
            try {
                
                $dados = $this->getRequest()->getParams();
                /* Obtem um unico usuário através do id passado */
                
                $obj = $this->_usuarios->find($dados['id'])->current();    
                
                $obj->delete();    
                
                


                $this->_dbAdapter->commit();
                
            $flashMessenger = $this->_helper->FlashMessenger;   
            $flashMessenger->addMessage('
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Sucesso</strong> - Tudo ocorreu bem!
                        </div>
                    ');
            
               echo true;
               exit;
            } catch (Zend_Db_Exception $e) {
                
                $this->_dbAdapter->rollBack();
                
                $flashMessenger = $this->_helper->FlashMessenger;   
                            $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                            </div>');
                exit;
            }
        }
    }
    

    public function resultadoAction(){


        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');

        $dados = $this->getRequest()->getParams();
        $request = $this->getRequest();

       if ($request->isPost()){
          $nome = $dados["nome_usuario"];
          $list = $this->_usuarios->fetchAll("usr_nome LIKE '%$nome%'","usr_id DESC");          
        }else{
           $list = array(); 
        }
        
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);
        $this->view->lista = $paginator;

    }

    public function solicitacoesAction(){


        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/switch/dist/js/switch.js');
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/usuarios/usuarios.js');

        
        $list = $this->_usuarios->fetchAll("usr_ativo = 0 ","usr_id DESC");          
        
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');

        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;


    }



}

