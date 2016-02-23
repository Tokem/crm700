function updateSendHash(){

    var TOKEM = $("#tokem").val();
    if(TOKEM!=''){
        PagSeguroDirectPayment.setSessionId(TOKEM);
        var senderHash = PagSeguroDirectPayment.getSenderHash();            
    }

}

function getBrandCard(cardNumber){            

    var cardNumber = cardNumber.substr(0,6);

      PagSeguroDirectPayment.getBrand({
      cardBin:cardNumber,
      success: function(response) {
         if(response.brand.name.length!=''||response.brand.name!='undefined'){
            $("#error_pag").hide("fast");
            $("#BrandCard").val(response.brand.name);
         }
    },
      error: function(response) {
            
            if(response.error){
                
                $("#info").hide("fast");
                $("#msg_error").html("");
                $("#msg_error").html("Houve um erro ao tentar identificar a bandeira do seu cartão");
                $("#error_pag").show("fast")

                $('html, body').animate({
                    scrollTop: $("#topo_tab").offset().top
                }, 1000);
            }
    },
    complete: function(response) {
        console.log("complete "+JSON.stringify(response));
    }

    })
}

function createCardToken(){

    var ccNum = $("#numero_cartao").val();
    var brandName = $("#BrandCard").val();
    var ccCvv = $("#codigo_seguranca").val();
    var ccExpMo = $("#mes_validade").val();
    var ccExpYr = $("#ano_validade").val();

    PagSeguroDirectPayment.createCardToken({
                cardNumber: ccNum,
                brand: brandName,
                cvv: ccCvv,
                expirationMonth: ccExpMo,
                expirationYear: ccExpYr,
                success: function(psresponse){
                    $("#TokemCard").val(psresponse.card.token);
                    $("#msg_error").html("");
                    $("#error_pag").hide("fast")
                },
                error: function(psresponse){
                    if(undefined!=psresponse.errors["30400"]) {

                        $("#info").hide("fast");
                        $("#msg_error").html("");
                        $("#msg_error").html("Dados do cartão inválidos.");
                        $("#error_pag").show("fast")

                    }else if(undefined!=psresponse.errors["10001"]){

                        $("#info").hide("fast");
                        $("#msg_error").html("");
                        $("#msg_error").html("Tamanho do cartão inválido.");
                        $("#error_pag").show("fast")

                    }else if(undefined!=psresponse.errors["10006"]){
                        
                        $("#info").hide("fast");
                        $("#msg_error").html("");
                        $("#msg_error").html("Tamanho do CVV inválido.");
                        $("#error_pag").show("fast")

                    }else if(undefined!=psresponse.errors["30405"]){
                        
                        $("#info").hide("fast");
                        $("#msg_error").html("");
                        $("#msg_error").html("Data de validade incorreta.");
                        $("#error_pag").show("fast")

                    }else if(undefined!=psresponse.errors["30403"]){
                        updateSendHash();
                        //Se sessao expirar, atualizamos a session
                    }else{
                        
                        $("#info").hide("fast");
                        $("#msg_error").html("");
                        $("#msg_error").html("Verifique os dados do cartão digitado.");
                        $("#error_pag").show("fast")

                    }                    
                    console.log('Falha ao obter o token do cartao.');
                    console.log(psresponse.errors);
                },
                complete: function(psresponse){
                    // console.log(psresponse);
                    // console.log(psresponse.card.token);
                    $("#TokemCard").val(psresponse.card.token)
                    updateSendHash();
                }
    });
}
function getInstallments(){
  
  PagSeguroDirectPayment.getInstallments({
  amount: $("input#valorPagto").val(),
  brand: $("input#bandeira").val(),
  maxInstallmentNoInterest: 2,
      success: function(response) {
          console.log("parcelamento success=" + response);
      },
      error: function(response) {
        console.log("parcelamento error=" + response);  
      },
      complete: function(response) {
          console.log("parcelamento complete=" + response);
      }

  })

}

// PagSeguroDirectPayment.getInstallments({
//                    amount: grandTotal,
//                    brand: RMPagSeguro.brand.name,
//                    success: function(response) {
//                        var parcelsDrop = document.getElementById('pagseguro_cc_cc_installments');
//                        for( installment in response.installments) break;
// //                       console.log(response.installments);
//                        var b = response.installments[RMPagSeguro.brand.name];
//                        parcelsDrop.length = 0;
//                        for(var x=0; x < b.length; x++){
//                            var option = document.createElement('option');
//                            option.text = b[x].quantity + "x de R$" + b[x].installmentAmount.toFixed(2).toString().replace('.',',');
//                            option.text += (b[x].interestFree)?" sem juros":" com juros";
//                            option.value = b[x].quantity + "|" + b[x].installmentAmount;
//                            parcelsDrop.add(option);
//                        }
// //                       console.log(b[0].quantity);
// //                       console.log(b[0].installmentAmount);

//                    },
//                    error: function(response) {
//                        console.log(response);
//                    },
//                    complete: function(response) {
// //                       console.log(response);
//                        RMPagSeguro.reCheckSenderHash();
//                    }
//                });
//            },
//             onFailure: function(response){
//                 return 0;
//             }
//         });


$(document).ready(function() {

VMasker(document.getElementById("cpf")).maskPattern('999.999.999-99');
VMasker(document.querySelector("#numero_cartao")).maskNumber();    

$('#form_cartao').formValidation({
        message: 'Este valor não é válido!',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nome_cartao: {
                validators: {
                    notEmpty: {
                        message: 'Nome do dono do cartão obrigatório'
                    },
                }
            },
            dia_aniversario: {
                validators: {
                    notEmpty: {
                        message: 'Dia do aniversário obrigatório'
                    },
                }
            },

            mes_aniversario: {
                validators: {
                    notEmpty: {
                        message: 'Mês do aniversário obrigatório'
                    },
                }
            },

            ano_aniversario: {
                validators: {
                    notEmpty: {
                        message: 'Ano do aniversário obrigatório'
                    },
                }
            },

            cpf: {
                validators: {
                    notEmpty: {
                        message: 'CPF obrigatório'
                    },
                    id: {
                            country: 'BR',
                            message: 'CPF Inválido'
                        }
                }
            },

            numero_cartao: {
                validators: {
                    notEmpty: {
                        message: 'Número do cartão de crédito obrigatório'
                    },
                }
            },

            mes_validade: {
                validators: {
                    notEmpty: {
                        message: 'Mês de validade obrigatório'
                    },
                }
            },

            ano_validade: {
                validators: {
                    notEmpty: {
                        message: 'Ano de validade obrigatório'
                    },
                }
            },

            codigo_seguranca: {
                validators: {
                    notEmpty: {
                        message: 'Código de segurança obrigatório'
                    },
                    stringLength: {
                        max: 4,
                        min: 3,
                        message: 'Código de segurança deve ter entre 3 ou 4 dígitos'
                    }

                }
            },                        
        }
    });
}).on('success.form.fv', function(e) {
        
        // Prevent form submission
        //e.preventDefault();

        var $form = $(e.target),
            fv    = $form.data('formValidation');

            $("#botao_pagamento").addClass("disabled");            
            
            var cardNumber = $("#numero_cartao").val();
            var cvv = $("#codigo_seguranca").val();
            var expirationMonth = $("#mes_validade").val();
            var expirationYear = $("#ano_validade").val();

            updateSendHash();
                    
            return false;

});

    
$("#numero_cartao").focusout(function(){
    updateSendHash();
    var cardNumber  = $("#numero_cartao").val();    
    if(cardNumber.length>=12){
        getBrandCard(cardNumber);    
    }else{
      
    }    

})


$("#codigo_seguranca").focusout(function(){
    updateSendHash();
    createCardToken();    
})


