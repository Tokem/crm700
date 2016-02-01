//Excluir
$(document).ready(function() {
        $('.remove_item').on('click',function(){

            var controller = $(this).attr("controller");
            var codigo = $(this).attr("id");
            var caminho = '/crm700/public/'+controller+'/excluir';
            var red = "notificacoes/index";
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
                        console.log(e);
                        return false;
                        window.location.replace(redirect);
                    }, error: function(e) {
                        window.location.replace(redirect);
                    }
                })

            });

            return false;    
        })

});

// Marcar como lido
//Excluir
$(document).ready(function() {
        $('.ver_notificacao').on('click',function(){

            var controller = $(this).attr("controller");
            var codigo = $(this).attr("id");
            var caminho = '/crm700/public/'+controller+'/ver';
            var redirect = $(this).attr("href");
            
            // console.log("redirect "+redirect);
            // console.log("codigo "+codigo);
            // console.log("caminho "+caminho);
            // console.log("controller "+controller);
            //return false;
        
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
});

