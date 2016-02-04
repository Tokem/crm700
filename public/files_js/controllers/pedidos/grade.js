$(function(){
  //$('.image_hover').popover();
  $('.image_hover').popover({ trigger: "hover",html: true });
})



$(function(){
  $('.remover_item_do_carrinho').on('click',function(){

  	var idProduto = $(this).attr("idproduto");
  	var numeracaoProduto = $(this).attr("numeracao");


  	alertify.defaults.glossary.title = 'AVISO! CRM700 GAUSS';
    alertify.confirm("Deseja realmente deletar este item?", function(){

                $.ajax({
                    url: "./excluir-item",
                    type: 'post',
                    data: {
                        id: idProduto,
                        numero: numeracaoProduto,
                    }, beforeSend: function() {
                    }, success: function(e) {                    	
                        location.reload();                    
                    }, error: function(e) {
                        window.location.replace(redirect);
                    }
                })

            });

            return false;    


  })

})


$(function(){
  $('.somar_item').on('click',function(){

    $("#botao_pagamento").removeClass("bg-light-blue");
    $("#botao_pagamento").addClass("btn btn-primary disabled");
    $("#botao_pagamento").prop('disabled', true);
    $("#botao_pagamento").html("Atualize o carrinho de compras!")

    var idProduto = $(this).attr("idprodutosoma");
    var numeracaoProduto = $(this).attr("numerosoma");

                $.ajax({
                    url: "./somar-item",
                    type: 'post',
                    data: {
                        id: idProduto,
                        numero: numeracaoProduto,
                    }, beforeSend: function() {
                    }, success: function(e) {
                        var valor = parseInt($( "#quantidade_"+idProduto).val());
                        valor +=1;
                        $( "#quantidade_"+idProduto).val(valor)
                        return false;
                        
                    }, error: function(e) {
                        window.location.replace(redirect);
                    }
                })

            });

            return false;    
})


$(function(){
  $('.subtrair_item').on('click',function(){

    $("#botao_pagamento").removeClass("bg-light-blue");
    $("#botao_pagamento").addClass("btn btn-primary disabled");
    $("#botao_pagamento").prop('disabled', true);
    $("#botao_pagamento").html("Atualize o carrinho de compras!")

    var idProduto = $(this).attr("idprodutosub");
    var numeracaoProduto = $(this).attr("numerosub");

                $.ajax({
                    url: "./subtrair-item",
                    type: 'post',
                    data: {
                        id: idProduto,
                        numero: numeracaoProduto,
                    }, beforeSend: function() {
                    }, success: function(e) {
                        var valor = parseInt($( "#quantidade_"+idProduto).val());
                        if(valor>1){
                          valor -=1;  
                        }
                        
                        $( "#quantidade_"+idProduto).val(valor)
                        return false;
                        
                    }, error: function(e) {
                        window.location.replace(redirect);
                    }
                })

            });

            return false;    
})
