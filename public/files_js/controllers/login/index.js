
$(document).ready(function() {


    $("#login").bootstrapValidator({

        message: 'Valor não aceito!',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            usuario: {
                validators: {
                    notEmpty: {
                        message: 'usuário Obrigatório!'
                    },
                }
            },senha: {
                validators: {
                    notEmpty: {
                        message: 'Senha obrigatória'
                    },
                }
            }
            
        }
    });

}).on('success.form.bv', function(e) {
    
    onLoginSuccess();    
    return false;
})


function onLoginSuccess(e) {


    var caminho = "/crm700/public/login";
    var usuario = $("#usuario").val();
    var senha = $("#senha").val();
    var redirect = "/crm700/public/pedidos/grade";

    $.ajax({
        url: caminho,
        type: 'post',
        data: {
            "usuario": usuario,
            "senha": senha,
        }, beforeSend: function() {
          $("#btn-login").html("Validando Acesso...")
          $("#mensagem").hide();   
        }, success: function(e) {

            console.log(e);

          setTimeout( function() {
                    $("#btn-login").html("Login");                    
                    var obj = jQuery.parseJSON(e);

                    if(obj.ativo!=1){
                       $("#mensagem").show();
                       $("#btn-login").prop('disabled',false);
                    }else{
                        window.location.replace("/crm700/public/pedidos/grade");
                    }

                    
                }, 2000 );
        }, error: function(e) {
          alert(e);
            console.log(e);
            alert(e);
            return false;
        }
    })

    return false;
  
};