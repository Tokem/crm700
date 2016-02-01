//Excluir
$(document).ready(function() {
        $('.remove_item').on('click',function(){

            var controller = $(this).attr("controller");
            var codigo = $(this).attr("id");
            var caminho = '/crm700/public/'+controller+'/excluir';
            var red = "usuarios/index";
            var redirect ='/crm700/public/'+red;
            
            
            alertify.defaults.glossary.title = 'AVISO! CRM700 GAUSS';
            alertify.confirm("Deseja realmente deletar este item?", function(){

                $.ajax({
                    url: caminho,
                    type: 'post',
                    data: {
                        id: codigo,
                    }, beforeSend: function() {
                    }, success: function(e) {
                        window.location.replace(redirect);
                    }, error: function(e) {
                        window.location.replace(redirect);
                    }
                })

            });

            return false;    
        })

});

if($(".ativo").length>0){
    $(".ativo").bootstrapSwitch();

    $(".ativo").on('switchChange.bootstrapSwitch', function(event, state) {
      var codigo = $(this).attr("codigo-usuario"); // DOM element
      var ativo =state;
      var caminho = "/crm700/public/usuarios/ativar";
      var verificarVendedor = "/crm700/public/usuarios/verificar-vendedor";


      $.ajax({
            url: caminho,
            type: 'POST',
            data:{usr_id:codigo,usr_ativo:ativo},
            success: function(result) {

                // console.log(result);
                // return false;

                //var obj = jQuery.parseJSON(result);
                // if(result!=1){

                //             $.ajax({
                //                 url: caminho,
                //                 type: 'POST',
                //                 data:{usr_id:codigo, usr_ativo:ativo},
                //                 success: function(result) {

                //                     console.log(result);
                //                     return false;

                                    if(result==1){
                                        alertify.defaults.glossary.title = 'CRM 700 Gauss';
                                        alertify.alert("Status do usuário modificado!");
                                    }else{
                                         alertify.defaults.glossary.title = 'ERRO CRM 700 Gauss';
                                         alertify.alert("Ocorreu um erro inesperado!");
                                    } 
                                    

                            //         return false;
                            //     },error: function(e) {
                            //         alertify.defaults.glossary.title = 'ERRO CRM 700 Gauss';
                            //         alertify.alert("Ocorreu um erro inesperado");
                            //     }
                            // });
                    
                    // }else{
                    //    alertify.defaults.glossary.title = 'CRM 700 Gauss';
                    //    alertify.confirm("Revendedor sem código de Vendedor! Adicione o código para ativar, Você será redirecionado...", function(){

                    //             alert("ok");

                    //     });
                    // }
                    

                    // return false;
            },error: function(e) {
                alertify.defaults.glossary.title = 'ERRO CRM 700 Gauss';
                alertify.alert("Ocorreu um erro inesperado");
            }
        });


    });

}
if ($('#fis_data_nasc').length) {
	$('#fis_data_nasc').datepicker({
		format: 'dd/mm/yyyy',
	});
}

$("#select_pergunta option").each(function(){

      if($(this).val() == "" && $(this).html() == ""){
      	$(this).remove();
      }
         
});

$("#select_estado option").each(function(){

      if($(this).val() == "" && $(this).html() == ""){
      	$(this).remove();
      }
         
});

$("#select_permissao option").each(function(){

      if($(this).val() == "" && $(this).html() == ""){
      	$(this).remove();
      }
         
});

$(function(){
	var pergunta = $("#pergunta").val();
	var estado = $("#estado").val();
	var permissao = $("#permissao").val();

	$("#select_pergunta").val(pergunta);
	$("#select_estado").val(estado);
	$("#select_permissao").val(permissao);
})

if($("#usr_senha").length>0){
   $("#usr_senha").pstrength();     
}


(function() {			
    if($("#fis_cpf").length>0){

    	VMasker(document.getElementById("fis_cpf")).maskPattern('999.999.999-99');
    	VMasker(document.getElementById("usr_telefone")).maskPattern('(99) 9999-9999');
    	VMasker(document.getElementById("usr_celular")).maskPattern('(99) 99999-9999');
    	VMasker(document.getElementById("end_cep")).maskPattern('99999-999');        
        VMasker(document.querySelector("#usr_tabela")).maskNumber();
  
    }
})();


$("#end_cep").focusout(function(){
	$("#modal_cep").modal("show");

	$("#end_bairro").val();
	$("#end_cidade").val();
	$("#end_estado").val();
	$("#end_logradouro").val();
	$("#loader").show();
	$("#mensage").html("");

	var url = "http://api.postmon.com.br/v1/cep/" + $("#end_cep").val();

	$.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
		                
            	setTimeout( function() {
                    	
                  
		                if(result.bairro.length>0){
		                	$("#end_bairro").val(result.bairro);
		                }
		                if(result.cidade.length>0){
		                	$("#end_cidade").val(result.logradouro);
		                }
		                if(result.estado_info.nome.length>0){
		                	$("#select_estado").val(result.estado_info.nome);
		                }
		                if(result.logradouro.length>0){
		                	$("#end_logradouro").val(result.logradouro);
		                }
		                
		                $("#modal_cep").modal("hide");
                      

                }, 3000 );
                
                

                return false;
            },error: function(e) {
        		setTimeout( function() {
		            $("#loader").hide('slow');
		            $("#mensage").html('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Warning</strong> Não Foi Possível achar o CEP Informado!</div>');
			            
			        setTimeout( function() {
			            $("#modal_cep").modal("hide");
	                }, 5000 );

                }, 3000 );
        	}
        });

})




$("#usr_id_fk_carteira").focusout(function(){
	
	var vendedor =  $("#usr_id_fk_carteira").val();

    var caminho = "/crm700/public/usuarios/procurar-vendedor";

	if(vendedor.length>0){
		$.ajax({
            url: caminho,
            type: 'POST',
            data:{usr_id_fk_carteira:vendedor},
            success: function(result) {

            	var obj = jQuery.parseJSON(result);
            	if(obj.mensagem!="ok"){
            		alertify.defaults.glossary.title = 'CRM 700 Gauss';
            		alertify.alert(obj.mensagem);
                     if(obj.disable.length>0){
                        $("#btn_enviar").prop("disabled", true);
                    }
            	}else{
                    $("#btn_enviar").prop("disabled", false);
                }

                return false;
            },error: function(e) {
        	}
        });
	}	

})


$("#usr_id_fk_agregado").focusout(function(){
	
	var revendedor =  $("#usr_id_fk_agregado").val();
    var caminho = "/crm700/public/usuarios/procurar-revendedor";

	if(revendedor.length>0){
		$.ajax({
            url: caminho,
            type: 'POST',
            data:{usr_id_fk_agregado:revendedor},
            success: function(result) {

            	var obj = jQuery.parseJSON(result);
            	if(obj.mensagem!="ok"){
            		alertify.defaults.glossary.title = 'CRM 700 Gauss';
            		alertify.alert(obj.mensagem);

                    if(obj.disable.length>0){
                        $("#btn_enviar").prop("disabled", true);
                    }

            	}else{
                    $("#btn_enviar").prop("disabled", false);
                }
            	
                return false;
            },error: function(e) {
        	}
        });
	}	

})

$("#usr_usuario").focusout(function(){
	
	var usuario =  $("#usr_usuario").val();
    var caminho = "/crm700/public/usuarios/procurar-usuario";

	if(usuario.length>0){
		$.ajax({
            url: caminho,
            type: 'POST',
            data:{usr_usuario:usuario},
            success: function(result) {

            	var obj = jQuery.parseJSON(result);
            	if(obj.mensagem!="ok"){
            		alertify.defaults.glossary.title = 'CRM 700 Gauss';
            		alertify.alert(obj.mensagem);

                    if(obj.disable.length>0){
                        $("#btn_enviar").prop("disabled", true);
                    }

            	}else{
                    $("#btn_enviar").prop("disabled", false);
                }
            	
                return false;
            },error: function(e) {
        	}
        });
	}	

})
