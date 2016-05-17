$(document).ready(function (){

	$("#entrega").attr("checked") ? $("#address_main").show() : $("#address_main").hide();

	if ($( "#selecao-item" ).length > 0) {
		if ($('#selecao-item').val() != '[Selecione um Produto]') { get_itens(); }
	}


	$("input[name='opcaoDelivery']").on( "click", function(){
		var order_id = $('#order_id').text();
		if ($(this).val() == 'Entrega') {
			var mode = $(this).val();

			var destino = $("#rua").text()+' - '+$("#bairro").text()+' '+$("#cidade").text()+'/'+$("#estado").text()+' - '+$("#cep").text();
			var origem = 'Rua Prof. Rodolfo Belz, 369 - Santa Cândida Curitiba - PR';
			var directionsService = new google.maps.DirectionsService();
			var request = {
				origin:origem,
				destination: destino,
				travelMode: google.maps.TravelMode.DRIVING
			};
			$("#address_main").show();
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					console.log(response);
					var route = response.routes[0];
					var distancia = route.legs[0].distance.text;
					var distance = parseFloat(distancia.split(" ")[0]) ;
					var result = distance * 0.29;
					//var r = result.toFixed(2)
					$("#distancia").text(distancia);
					var frete = result.toFixed(2);
					$("#frete").text('R$ '+frete.replace('.', ','));

					var address = Number($('#address_id').text());
					var freight = frete.replace(',', '.');

					return save_delivery_mode(order_id, mode, address, freight, distance);
				} else {
					$("#distancia").text('Endereço não encontrado. Verifique se seu endereço está correto.');
					return $("#frete").text('Não Calculado.');
				}
			});

		} else {
			$("#address_main").hide();
			return save_delivery_mode(order_id, $(this).val(), null, 0.00, 0);

		}
	});

	$('#selecao-item').change(function(){
		if ($('#selecao-item').val() == '[Selecione um Produto]') {
			$('#selecao-sabor-item').val('[Selecione o Sabor]');
			$('#selecao-sabor-item').attr('disabled', 'disabled');
			return false;
		}

		get_itens();
	});

	function get_itens() {
		var category = $('#selecao-item').val().toLowerCase();
		var url = 'order/itens/'+category;

		$('#selecao-sabor-item').removeAttr('disabled');
		$.ajax({
			type: 'GET',
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			url: url,
			success: function(data, status) {
				console.log(data);
				$('#selecao-sabor-item').children().remove();
				$.each(data, function(index, item){
					$("#selecao-sabor-item").append(new Option(item.name, item.id+'|'+item.name+'|'+item.package_price));
				});
			},
			error: function(data, status) {
				alert('Erro ao tentar carregar os sabores detsa categoria!!');
			},
		});
	}

	function save_delivery_mode(order_id, mode, address, freight, distance) {

		var url = 'order/delivery-mode';
		//alert('Order id: '+order_id+' Mode: '+mode+' Address: '+address+' Freight: '+freight);
		$.ajax({
			type: 'POST',
			url: url,
			data: {'order_id' : order_id, 'mode' : mode, 'address_id' : address, 'freight' : freight, 'distance': distance},
			success: function(data, status) {
				console.log(data);
			},
			error: function(data, status) {
				alert('Erro ao tentar salvar o modo delivery');
			},
		});

	}



/*$("#add-item").click(function(event) {
   var order_id = $('#order_id').text();
   var url = 'order/'+order_id+'/itens';

   $.ajax({
      type: 'POST',
      data: $("#itens-form").serialize(),
      url: url,
      success: function(data, status) {
         console.log(data);
      },
      error: function(data, status) {
         alert('Erro ao tentar salvar um novo item!');
      },
   });
 });*/

});