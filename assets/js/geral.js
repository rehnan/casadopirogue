$(function(){
		/*******************************************************
        * PÁGINA DO PEDIDO 
		*******************************************************/
		$(document).ready(function() {
			$("#selecao-pedido").change(function(event) {
				var pedido = $("#selecao-pedido").val();
				if (pedido == 'Pastel') {
					$("#integral").css({"display":"block"});
				}else{
					$("#integral").css({"display":"none"});	
				}
			});
		});

		$(document).ready(function() {
			$("#botoes").click(function(event) {
				$("#titulos").css({"color":"#3B9C00"});

			});
	
			
			
			
		});

		

});