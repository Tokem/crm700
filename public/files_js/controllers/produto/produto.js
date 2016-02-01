$(function(){
  //$('.image_hover').popover();
  $('.image_hover').popover({ trigger: "hover",html: true });
})

//Excluir
$(document).ready(function() {
        $('.remove_item').on('click',function(){

            var controller = $(this).attr("controller");
            var codigo = $(this).attr("id");
            var caminho = '/crm700/public/'+controller+'/excluir';
            var red = "produto/index";
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

$(document).ready(function() {
        $('.remove_image').on('click',function(){
            
            var element = $(this);
            var controller = $(this).attr("controller");
            var codigo = $(this).attr("id");
            var caminho = '/crm700/public/'+controller+'/excluirimagem';
            var red = "produto/index";
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
                        element.parent().parent().remove();
                    }, error: function(e) {
                      window.location.replace(redirect);
                    }
                })

            });

            return false;    
        })

});

$("#select_categoria option").each(function(){

      if($(this).val() == "" && $(this).html() == ""){
      	$(this).remove();
      }
         
});


$(function(){
  var categoria = $("#categoria").val();
  $("#select_categoria").val(categoria);
})


$(function(){

  if($("#pro_valor").length > 0 ){
      VMasker(document.querySelector("#pro_valor")).maskMoney({
        // Decimal precision -> "90"
        precision: 2,
        // Decimal separator -> ",90"
        separator: ',',
        // Number delimiter -> "12.345.678"
        delimiter: '.',
        // Money unit -> "R$ 12.345.678,90"
        // unit: 'R$',
        // Money unit -> "12.345.678,90 R$"
        // suffixUnit: 'R$',
        // Force type only number instead decimal,
        // masking decimals with ",00"
        // Zero cents -> "R$ 1.234.567.890,00"
        zeroCents: false
      });
  }

})

if($("#pro_pontos").length > 0 ){
  VMasker(document.querySelector("#pro_pontos")).maskNumber();  
}

