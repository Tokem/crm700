// $(document).ready(function() {
//     $.ajax({
//             url: "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions",
//             type: 'POST',
//             data:{'email':"vendas@700gauss.com.br",
//             'tokem':"FB2D418A7BAB43D29A21B96E385FE847",
//             },

//             success: function(result) {
//                 console.log("sucesso =="+result);
//                 return false;
//             }
//             ,error: function(result){
//                 console.log("error =="+result);
//                 var acc = []
//                 $.each(result, function(index, value) {
//                     acc.push(index + ': ' + value);
//                 });
//                 console.log(JSON.stringify(acc));
//                 return false;   
//             }
//         });
// })


$(document).ready(function() {


VMasker(document.getElementById("cpf")).maskPattern('999.999.999-99');    

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

            var TOKEM = $("#tokem").val();
            PagSeguroDirectPayment.setSessionId("TOKEM");
            var senderHash = PagSeguroDirectPayment.getSenderHash();
            
             PagSeguroDirectPayment.getPaymentMethods({
                amount:'500.00',
                beforeSend: function(){
                    PagSeguroDirectPayment.setSessionId("TOKEM");
                },
                success: function(response){
                    console.log("sucess "+JSON.stringify(response));
                },
                error: function(response){
                    console.log("error "+JSON.stringify(response));
                },
                complete: function(response){
                    console.log("complete "+JSON.stringify(response));
                }               
            })   
              
            // PagSeguroDirectPayment.getBrand({
            //   cardBin: 411111,
            //   success: function(response) {
            //      console.log("sucess "+JSON.stringify(response));
            // },
            //   error: function(response) {
            //     console.log("error "+JSON.stringify(response));
            //     },
            // complete: function(response) {
            //     console.log("complete "+JSON.stringify(response));
            // }

            return false;

});
