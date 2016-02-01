$(document).ready(function() {
	//$('#table_usuarios').DataTable();

	var usuarios =   $('#table_vendedores').dataTable({
            	

	language: {
	    "sEmptyTable": "Nenhum registro encontrado",
	    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
	    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
	    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
	    "sInfoPostFix": "",
	    "sInfoThousands": ".",
	    "sLengthMenu": "_MENU_ Itens por página",
	    "sLoadingRecords": "Carregando...",
	    "sProcessing": "Processando...",
	    "sZeroRecords": "Nenhum registro encontrado",
	    "sSearch": "Pesquisar",
	    "oPaginate": {
	        "sNext": "Próximo",
	        "sPrevious": "Anterior",
	        "sFirst": "Primeiro",
	        "sLast": "Último"
	    },
	    "oAria": {
	        "sSortAscending": ": Ordenar colunas de forma ascendente",
	        "sSortDescending": ": Ordenar colunas de forma descendente"
	    }
    }


            ,
            "iDisplayLength": 50,
            "aoColumnDefs": [
              { 'bSortable': false, 'aTargets': [ 0 ] }
            ],
            "aaSorting" : [[0, 'desc']],
            "bStateSave": true,    
            
            "oTableTools": {
                "aButtons": []
            }
        });

} );




$(document).ready(function() {

	$(".btn-procurar_revendedor").on('click',function(){
		var revendedor = $("#procurar_revendedor_input").val();
		
		if(revendedor.length==""){
			alert("Digite o nome do revendedor");
		}else{

			$.ajax({
            url: "procurar-revendedor/",
            type: 'POST',
            data: {'nome_revendedor': revendedor},

            success: function(result) {
		                
            	console.log(result);
            	return false;	

            },error: function(e) {
        	
        	}
        	
        	});
		}
	});

	
	// var revendedores =   $('#table_revendedores').dataTable({
            	
	// language: {
	//     "sEmptyTable": "Nenhum registro encontrado",
	//     "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
	//     "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
	//     "sInfoFiltered": "(Filtrados de _MAX_ registros)",
	//     "sInfoPostFix": "",
	//     "sInfoThousands": ".",
	//     "sLengthMenu": "_MENU_ Itens por página",
	//     "sLoadingRecords": "Carregando...",
	//     "sProcessing": "Processando...",
	//     "sZeroRecords": "Nenhum registro encontrado",
	//     "sSearch": "Pesquisar",
	//     "oPaginate": {
	//         "sNext": "Próximo",
	//         "sPrevious": "Anterior",
	//         "sFirst": "Primeiro",
	//         "sLast": "Último"
	//     },
	//     "oAria": {
	//         "sSortAscending": ": Ordenar colunas de forma ascendente",
	//         "sSortDescending": ": Ordenar colunas de forma descendente"
	//     }
 //    }


 //            ,
 //            "iDisplayLength": 50,
 //            "aoColumnDefs": [
 //              { 'bSortable': false, 'aTargets': [ 0 ] }
 //            ],
 //            "aaSorting" : [[0, 'desc']],
 //            "bStateSave": true,    
            
 //            "oTableTools": {
 //                "aButtons": []
 //            },

 //            "processing": true,
 //        	"serverSide": true,
 //        	"ajax": {
 //            "url": "procurar-revendedor",
 //            "data": function ( d ) {
 //                d.myKey = "myValue";
 //                // d.custom = $('#myInput').val();
 //                // etc
 //            },type:'post',
 //            "initComplete": function( settings, json ) {
	// 		    $('div.loading').remove();
	// 		}
 //   //          success: function ( txt ) {
	// 		// 	//console.log(txt);				
	// 		// }
 //        	}
 //        });


} );


// $(document).on('change', '#table_revendedores', function (event) {
//     oTable.fnReloadAjax();
// });


$(function(){
	$('#table_revendedores').dataTable( {
  "ajax": {
    "url": "procurar-revendedor",
    "type": "POST"
  }
} );	
})

