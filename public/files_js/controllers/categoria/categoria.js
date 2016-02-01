//Excluir
$(document).ready(function() {
        $('.remove_item').on('click',function(){

            var controller = $(this).attr("controller");
            var codigo = $(this).attr("id");
            var caminho = '/crm700/public/'+controller+'/excluir';
            var red = "categoria/index";
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