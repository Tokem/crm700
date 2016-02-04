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


