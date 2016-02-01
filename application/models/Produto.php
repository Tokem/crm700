<?php

class Application_Model_Produto extends Zend_Db_Table
{

	protected $_name = "produto";
    protected $_primary = "pro_id";



    public function getAll(){

    	$db = $this->getDefaultAdapter();
        $lista = $db->select()->from(array('pr' => 'produto'))
        	     ->distinct()
			     ->join(array('im' => 'imagens'),'pr.pro_id = im.pro_id_fk')
                 ->order(array('pr.pro_nome DESC'));;
			     // ->query()->fetchAll();    

		// echo $lista;		     
		// exit;
        return $produtos =  $db->fetchAll($lista);
    }


}

