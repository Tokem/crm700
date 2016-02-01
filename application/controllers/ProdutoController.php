<?php

class ProdutoController extends Tokem_ControllerBase
{


    protected $_produto = null;
    protected $_imagens = null;
    protected $_identity = null;
    protected $_baseUrl = null;

    public function init()
    {
        parent::init();

        $this->_baseUrl = $url = Zend_Controller_Front::getInstance()->getBaseUrl();        
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/vanilla-masker/vanilla-masker.js');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/switch/dist/css/bootstrap3/switch.css');
        $this->view->headLink()->appendStylesheet('/crm700/public/plugins/alertifyjs/css/alertify.min.css');
        $this->view->headScript()->appendFile($this->_baseUrl . '/plugins/alertifyjs/alertify.min.js');
        
        $this->view->headScript()->appendFile($this->_baseUrl . '/files_js/controllers/produto/produto.js');


        $this->_produto = new Application_Model_Produto();
        $this->_imagens = new Application_Model_ImagensProdutos();
        $this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $auth = Zend_Auth::getInstance();
        $identity = $auth->getIdentity();
        $this->_identity = $identity;

    }

    public function indexAction()
    {


        $list = $this->_produto->fetchAll(null,"pro_nome ASC"); 
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(50);

        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
        $this->view->lista = $paginator;
        $this->view->paginator = $paginator;

    }

    public function resultadoAction(){


        $dados = $this->getRequest()->getParams();
        $request = $this->getRequest();        

       if ($request->isPost()){
          $nome = $dados["pro_nome"];
          $list = $this->_produto->fetchAll("pro_nome LIKE '%$nome%'","pro_id DESC");          
        }else{
           $list = array(); 
        }
        
        $paginator = Zend_Paginator::factory($list);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(200);
        $this->view->lista = $paginator;

    }

    public function cadastrarAction()
    {

        $form = new Application_Form_Produto();
        $form->setAction($this->_helper->url('cadastrar'));
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();

        if ($request->isPost() && $form->isValid($request->getPost())) {

            $numeros = $dados["pro_tamanhos"];

            foreach ($numeros as $key => $value) {
                        $numeracao[] = $value;
                    }

            $json =  json_encode($numeracao);
            $valor = str_replace('.', '',$dados["pro_valor"]);
            $valor = str_replace(',', '.',$valor);



            $produto = array(
                "pro_nome"=> $dados["pro_nome"],
                "pro_identificador"=> @$dados["pro_identificador"],
                "pro_descricao"=> $dados["pro_descricao"],
                "pro_valor"=> $valor,
                "pro_tamanhos"=> $json,
                "cat_id_fk"=> $dados["select_categoria"],
                "pro_pontos"=> $dados["pro_pontos"],
            );

            try {
                
                $lastId = $this->_produto->insert($produto);    

            } catch (Zend_Db_Exception $e) {
                // echo $e->getMessage();
                // exit;
                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                </div>');
                
                $this->_helper->redirector('index');     
                exit;
            }

             /** 
             Faz o upload das imagens
             **/

            $dir = "./uploads/produtos/";
            
            $adapter = new Zend_File_Transfer_Adapter_Http(); 
            
           
            try {

                $this->_imagens = new Application_Model_ImagensProdutos();

                $form->getElement('imagens')->setDestination("$dir");

                foreach ($adapter->getFileInfo() as $file => $info) {
                    if ($adapter->isUploaded($file)) {

                        $name = $adapter->getFileName($file);

                        require_once APPLICATION_PATH . '/../library/Tokem/Functions/functions.php';
                        $fileName = removeAcentos($info['name']);
                        $newFileName = strtolower(str_replace(' ', '',$fileName));
                        
                        $img_nome = md5(microtime()).'_'.$newFileName;
                        $fname = $dir ."/". $img_nome;
                        $caminho  = ltrim($dir, ".");
                        $image = array(
                            "ima_nome"=>"$img_nome",
                            "pro_id_fk"=>$lastId);
                                                
                        
                            $this->_imagens->insert($image);          
                            
                        
                        
                        /**
                         *  Let's inject the renaming filter
                         */
                        $adapter->addFilter(new Zend_Filter_File_Rename(array('target' => $fname, 'overwrite' => true)), null, $file);
                        /**
                         * And then we call receive manually
                         */
                        $adapter->receive($file);
                    }
                }  
                
                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('
                    <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Sucesso</strong> - Tudo ocorreu bem!
                    </div>
                ');
                            

                $this->_helper->redirector('index');
                exit; 
                
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;

                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                </div>');
                
                $this->_helper->redirector('index');     
                exit;                
            }


            /**
            fim do upload de imagens
            **/




        }

        $this->view->categoria = @$dados["select_categoria"];
        $this->view->form = $form;
        
    }

    public function editarAction()
    {
        $form = new Application_Form_Produto();

        $form->setAction($this->_helper->url('editar'));
        $request = $this->getRequest();
        $dados = $this->getRequest()->getParams();

        $id = $this->getRequest()->getParam('id');
        $dados = $this->getRequest()->getParams();
        $form->setAction($this->_helper->url('editar/id/' . $id));
        
        /* Obtem um unico usuário através do id passado */
        $produto = $this->_produto->find($id)->current();

        $imagens = $this->_imagens->fetchAll("pro_id_fk='$id'","ima_id DESC");
        $produto->pro_tamanhos = json_decode($produto->pro_tamanhos);
        $this->view->categoria = $produto->cat_id_fk;
        $this->view->imagens = $imagens;
        $produto->pro_valor = number_format( $produto->pro_valor , 2, ',', '.');
        
        $form->populate($produto->toArray());
        if ($request->isPost() && $form->isValid($request->getPost())) {
            
            try {

                $numeros = $dados["pro_tamanhos"];
                foreach ($numeros as $key => $value) {
                            $numeracao[] = $value;
                        }
                $json =  json_encode($numeracao);
                $valor = str_replace('.', '',$dados["pro_valor"]);
                $valor = str_replace(',', '.',$valor);       
                

                $produto->pro_nome = $dados["pro_nome"];
                $produto->pro_identificador = $dados["pro_identificador"];
                $produto->pro_descricao = $dados["pro_descricao"];
                $produto->pro_valor = $valor;
                $produto->pro_tamanhos = $json;
                $produto->pro_pontos = $dados["pro_pontos"];
                $produto->save();

                      /** 
             Faz o upload das imagens
             **/

            $dir = "./uploads/produtos/";
            
            $adapter = new Zend_File_Transfer_Adapter_Http(); 
            
           
            try {

                $this->_imagens = new Application_Model_ImagensProdutos();

                $form->getElement('imagens')->setDestination("$dir");

                foreach ($adapter->getFileInfo() as $file => $info) {
                    if ($adapter->isUploaded($file)) {

                        $name = $adapter->getFileName($file);

                        require_once APPLICATION_PATH . '/../library/Tokem/Functions/functions.php';
                        $fileName = removeAcentos($info['name']);
                        $newFileName = strtolower(str_replace(' ', '',$fileName));
                        
                        $img_nome = md5(microtime()).'_'.$newFileName;
                        $fname = $dir ."/". $img_nome;
                        $caminho  = ltrim($dir, ".");
                        $image = array(
                            "ima_nome"=>"$img_nome",
                            "pro_id_fk"=>$id);
                                                
                        $imagem = $this->_imagens->fetchRow("pro_id_fk='$id'");

                        if(!empty($imagem)){
                            unlink("../public/uploads/produtos/".$imagem->ima_nome);
                            $imagem->ima_nome = $img_nome;
                            $imagem->save();

                        }else{
                            $this->_imagens->insert($image);              
                        }
                        
                        
                        
                        /**
                         *  Let's inject the renaming filter
                         */
                        $adapter->addFilter(new Zend_Filter_File_Rename(array('target' => $fname, 'overwrite' => true)), null, $file);
                        /**
                         * And then we call receive manually
                         */
                        $adapter->receive($file);
                    }
                }  
                
                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('
                    <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Sucesso</strong> - Tudo ocorreu bem!
                    </div>
                ');
                            

                $this->_helper->redirector('index');
                exit; 
                
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;

                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                </div>');
                
                $this->_helper->redirector('index');     
                exit;                
            }


            /**
            fim do upload de imagens
            **/
                
                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('
                    <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Sucesso</strong> - Tudo ocorreu bem!
                    </div>
                ');
                
            } catch (Zend_Db_Exception $e) {
                echo $e->getMessage();
                        exit;
                $flashMessenger = $this->_helper->FlashMessenger;   
                $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                    </div>');
                
            }

            $this->_helper->redirector('index');     
            exit;

        }

        $this->view->form = $form;
    }

    public function excluirAction(){

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $this->_dbAdapter->beginTransaction();
            
            try {
                
                $dados = $this->getRequest()->getParams();
                /* Obtem um unico usuário através do id passado */
                
                $obj = $this->_produto->find($dados['id'])->current();    
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
                // echo $e->getMessage();
                //         exit;
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


    public function excluirimagemAction(){

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $this->_dbAdapter->beginTransaction();
            
            try {
                
                $dados = $this->getRequest()->getParams();
                $obj = $this->_imagens->find($dados['id'])->current();    
                unlink("../public/uploads/produtos/".$obj->ima_nome);
                $obj->delete();    
                $this->_dbAdapter->commit();
                
               echo true;
               exit;
            } catch (Zend_Db_Exception $e) {
                // echo $e->getMessage();
                //         exit;
                // $this->_dbAdapter->rollBack();
                
                $flashMessenger = $this->_helper->FlashMessenger;   
                            $flashMessenger->addMessage('<div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>ERRO</strong> - Ocorreu um erro inesperado! se persistir entre em contato com o suporte!
                            </div>');
                exit;
            }
        }
    }

    public function verAction()
    {
        // action body
    }


}









