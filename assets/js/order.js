$(document).ready(function (){

	$("#address_main").hide();

	if ($( "#selecao-item" ).length > 0) {
		if ($('#selecao-item').val() != '[Selecione um Produto]') { get_itens(); }
	}

	$("input[name='opcaoDelivery']").click(function(){
		var order_id = $('#order_id').text();
		var address_id = 0;
		var freight = 0;
		if ($(this).val() === 'Entrega') {


			var destino = $("#rua").text()+' - '+$("#bairro").text()+' '+$("#cidade").text()+'/'+$("#estado").text()+' - '+$("#cep").text();
			var origem = 'Rua Prof. Rodolfo Belz, 369 - Santa Cândida Curitiba - PR';
			var directionsService = new google.maps.DirectionsService();
			var request = {
				origin:origem,
				destination: destino,
				travelMode: google.maps.TravelMode.DRIVING
			};

			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					console.log(response);
					var route = response.routes[0];
					var distancia = route.legs[0].distance.text;
					var result = parseFloat(distancia.split(" ")[0]) ;
					result = result * 0.29;
					//var r = result.toFixed(2)
					$("#distancia").text(distancia);
					var frete = result.toFixed(2);
					$("#frete").text('R$ '+frete.replace('.', ','));

					address_id = $('#address_id').text();
					freight = $('#frete').text();
					save_delivery_mode(order_id, $(this).val());
				} else {
					$("#distancia").text('Endereço não encontrado.');
					$("#frete").text('Frete não pode ser calculado.');
				}
			});
			return $("#address_main").show();
		}
		save_delivery_mode(order_id, $(this).val());
		return $("#address_main").hide();
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

	function save_delivery_mode($order_id, $mode) {

		var url = 'order/'+$order_id+'/delivery-mode/'+$mode;
		alert(url);
		$.ajax({
			type: 'GET',
			url: url,
			success: function(data, status) {
				console.log(data);
			},
			error: function(data, status) {
				alert('Erro ao tentar carregar os sabores detsa categoria!!');
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