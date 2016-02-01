<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Notification
 *
 * @author rodolfo
 */
class Tokem_Notification {
    
    
    /*
     * URL do site
     */
    private function getNomeSite(){
        $nomeSite = "DUCAJOBS (Ducamaleão)";
       
        return $nomeSite;
    }
    
    /*
     * URL do autoclube
     */
    private function getUrl(){
        $url = "http://www.ducamaleao.com.br";
       
        return $url;
    }
    
    
    private function getEmail(){
        $url = "suporte@ducamaleao.com.br";
       
        return $url;
    }
    
    /*
     * Configuracoes do envio do email
     */
    private function getHeader(){
        $header = "MIME-Version: 1.0 \r\n";
        $header .= "Content-type: text/html; charset=UTF-8 \r\n";
        $header .= "From: ".$this->getNomeSite()." <".$this->getEmail()."> \r\n";
        return $header;
    }
    
    /*
     * Cabecalho do email
     */

    //Tamanho da imagem para cabeçalho 686x92

    private function getCabecalho(){
        $cabecalho = "
            <html>
            <head></head>

            <body>
            <table width='685' border='0'>
                <tr>
                    <td height='467' valign='top' bgcolor='#f3f3f2'>
                        <table width='685' border='0'>
                            <tr>
                                <td width='37' height='134'>&nbsp;</td>
                                <td width='711'><img src='http://www.ducamaleao.com.br/ducajobs/public/img/mail/topo.gif' width='711' height='116' /></td>
                                <td width='37'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td height='203'>&nbsp;</td>     
                                <td valign='top' bgcolor='#FFFFFF' style='border:1px solid #dcdbdb; font-size:14px; line-height:1.3em;padding:27px;font-family:arial;'>
        ";
        return $cabecalho;
    }
    
    /*
     * Rodape do email
     */
    private function getRodape(){
        $rodape = "  
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td height='27' colspan='3'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan='3' style='text-align:center; padding:20px; color:#000000; background:#f3f3f2; height:90px; font-family:arial; font-size:11px;'>
                                    <p>Para garantir que nossos comunicados cheguem em sua caixa de entrada, <br />adicione o e-mail ".$this->getEmail()." ao seu catálogo de endereços.</p>
                                    <p></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </body>
            </html>
        ";
        return $rodape;
    }
    
    /*
     * Envia email para o cliente com os dados da nofificação
     */
    public function mail($array) {
        
        $assunto = "[".$this->getNomeSite()."] Ducajobs";
        
        
        $corpo = array();
        
        foreach ($array as $key => $value) {
        $$key = $value; 
        
            $corpo .="<p>$key: $value</p>";
        
        }
        
        $corpo = str_replace("Array", "", $corpo);
        $mensagem = $this->getCabecalho() . $corpo . $this->getRodape();
        
        $emailEnviado = mail($array["Login"],"DUCAJOBS 1.0",$mensagem,$this->getHeader());
        
        return $emailEnviado;
    }
    
}

?>
