<?php

class LoginController extends Tokem_ControllerBase {

    protected $_log = null;

    public function init() {
        $this->_helper->layout->disableLayout();
    }

    protected function _getAuthAdapter() {
        
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $adapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $adapter->setTableName('usuarios')
                ->setIdentityColumn('usr_usuario')
                ->setCredentialColumn('usr_senha');
                //->setCredentialTreatment('MD5(?)');
        return $adapter;
    }

    public function indexAction() {


        $auth = Zend_Auth::getInstance();
        $loggedIn= $auth->hasIdentity();    

        if($loggedIn){
           $this->_redirect('/pedidos/grade');
           exit; 
        }

        $request = $this->getRequest();

        if ($request->isPost() && !empty($_POST)) {

            // pega o adaptador de autenticação configurado
            $adapter = $this->_getAuthAdapter();

            // põe os dados que serão autenticados
            $adapter->setIdentity($_POST['usuario'])
                    ->setCredential($_POST['senha']);

    

            //realiza a autenticação em si
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter); // Zend_Auth_Result



            // var_dump($result);
            // exit;

            // verifica se deu certo
            if ($result->isValid()) {
                // se der certo, pega o registro da tabela
                $usuario = $adapter->getResultRowObject();

                // grava o registro autenticado na sessão
                $auth->getStorage()->write($usuario);

                $auth = Zend_Auth::getInstance();
                $identity = $auth->getIdentity();                

                $url = Zend_Controller_Front::getInstance()->getBaseUrl();        

                    $cookie = new Zend_Http_Cookie("tokem",
                               "$identity->usr_email",
                               "$url",
                               time() + 7200,
                               "/data/cookie");


                $login = array("resultado"=>"1","permissao"=>"$identity->usr_permissao","ativo"=>"$identity->usr_ativo");

                echo $status = json_encode($login);
                exit;

            } else {
                // se não deu certo, ver qual foi o erro
                $code = $result->getCode();

                if ($code == Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND || $code == Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID) {
                    
                    
                    $login = array("resultado"=>"0","permissao"=>"sem permissão");
                    echo $status = json_encode($login);
                exit;
                    exit;
                } else {
                    $this->view->mensagem = 'Error login';
                    echo "error 02";
                    exit;
                }
            }
        }
    }

    public function logoutAction() {
        // Apaga da instância do Zend Auth a identificação no sistema.
        Zend_Auth::getInstance()->clearIdentity();


        $flashMessenger = $this->_helper->FlashMessenger;   
            $flashMessenger->addMessage('
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Sucesso</strong> - Você esta fora do sistema!
                        </div>
                    ');
            

        // Redireciona para a página inicial do site.
        $this->_redirect('login');
    }

    public function recuperarSenhaAction() {

    }


}
