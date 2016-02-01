<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateFormat
 *
 * @author Rodolfo almeida
 */

/*Formata a data */
class Zend_View_Helper_ButtonLine extends Zend_View_Helper_Abstract {
    
    public function buttonLine($value){
        
       echo "<div class=\"btn-group\" >
                <button type=\"button\" status=\"0\" acao=\"nao-iniciar\" ln-codigo=\"$value\" class=\"btn-line btn btn-default\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Não Iniciar\"><span class=\"icon-ban-circle\"></span></button>
                <button type=\"button\" status=\"1\" acao=\"iniciar\" ln-codigo=\"$value\" class=\"btn-line btn btn-default\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Iniciar\"><span class=\"icon-play\"></span></button>
                <button type=\"button\" status=\"2\" acao=\"concluir\" ln-codigo=\"$value\" class=\"btn-line btn btn-default\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Concluir\"><span class=\"icon-flag\"></span></button>
                <button type=\"button\" status=\"3\" acao=\"parar\" ln-codigo=\"$value\" class=\"btn-line btn btn-default\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Parar\"><span class=\"icon-stop\"></span></button>
                <button type=\"button\" status=\"4\" acao=\"refazer\" ln-codigo=\"$value\" class=\"btn-line btn btn-default\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Refazer\"><span class=\"icon-fast-backward\"></span></button>
                <button type=\"button\" status=\"5\" acao=\"aprovacao\" ln-codigo=\"$value\" class=\"btn-line btn btn-default\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-original-title=\"Ir para aprovação\"><span class=\"icon-time\"></span></button>
             </div>";

    }
    
}
?>
