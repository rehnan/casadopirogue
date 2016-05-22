$(document).ready(function (){

	$("#example-basic").steps({
		headerTag: "h3",
		bodyTag: "section",
		transitionEffect: "slideLeft",
		autoFocus: true,
		labels: {
			cancel: "Cancelar",
			current: "Passo Atual:",
			pagination: "Pagination",
			finish: "Finalizar Pedido",
			next: "Próximo Passo",
			previous: "Voltar ",
			loading: "Carregando ..."
		},

		onStepChanging: function (event, currentIndex, newIndex)
		{
			clear_flash();
			if (newIndex > 0) {
				if ($('#itens_amount_badge').text() == 0) {
					flash('warning', 'Você deve adicionar o(s) produto(s) no carrinho antes de ir para o próximo passo da compra.');
					return false;
				}
			}

			if (newIndex === 2) {
				if ($('#entrega').is(':checked')) {
	    	 		//validação de um endereço principal configurado
	    	 		if ($('#set-main-address-flash').is(':visible')) {
	    	 			flash('warning', 'Você deve configurar um endereço principal para que o cálculo da frete possa ser realizado.');
	    	 			return false;
	    	 		}

	    	 		//Validação se o cálculo da frente foi efetuado
	    	 		if ($('#frete').text() == 'Não Calculado.' || $('#frete').text() == '') {
	    	 			flash('error', 'O frete não pôde ser calculado. Verifique se as informações do endereço principal configurado estão corretas.');
	    	 			return false;
	    	 		}
	    	 	}
	    	 }

	    	 ((currentIndex === 0 || currentIndex === 2) && $('#entrega').is(':checked')) ? calculate_freight ('Entrega') : '';
	    	 return true;
	    	},

	    	onFinishing: function (event, currentIndex) {
	    		if($('#table-total').is(':visible') && currentIndex === 2) {
	    			if ($('#itens_amount_badge').text() <= 0) {
	    				flash('warning', 'Você deve adicionar os produtos desejados antes de finalizar o pedido. Volte para o Passo: <b>1. Escolha dos Produtos</b>');
	    				return false;
	    			}
	    			if (finish_order()) {
	    				return true;
	    			}
	    		};
	    		return false;
	    	}
	    });


	$("#entrega").attr("checked") ? $("#address_main").show() : $("#address_main").hide();

	if ($('#selecao-item').is(':visible') === true) {
		if ($('#selecao-item').val() != '[Selecione um Produto]') { get_itens(); }
	}


	$("input[name='opcaoDelivery']").on( "click", function(){
		return calculate_freight ($(this).val())
	});

	function calculate_freight (mode_delivery_selected) {
		var order_id = $('#order_id').text();
		if (mode_delivery_selected == 'Entrega') {
			var mode = mode_delivery_selected;

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
					$("#distancia").text('Não Encontrada');
				       $("#frete").text('Não Calculado.');
					flash('error', 'O frete não pôde ser calculado. Verifique se as informações do endereço principal configurado estão corretas.');
    	 				return false;
				}
			});

		} else {
			$("#address_main").hide();
			return save_delivery_mode(order_id, $(this).val(), null, 0.00, 0);

		}

	}

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
		$.ajax({
			type: 'POST',
			url: url,
			data: {'order_id' : order_id, 'mode' : mode, 'address_id' : address, 'freight' : freight, 'distance': distance},
			success: function(data, status) {
				var description_mode = (mode === 'Entrega') ? 'Solicitar entrega do pedido em meu endereço principal.' : 'Retirar o pedido no estabelecimento.';
				flash('success', 'Modo atualizado com sucesso para:  '+description_mode);
			},
			error: function(data, status) {
				alert('asas');
			},
		});
	}


	$('a[href$="#next"]').click(function(event) {
		if($('#table-total').is(':visible')) {
			return load_order_finish();
		}
	});


	function finish_order() {
		var order_id = $('#order_id').text();
		var url = 'order/'+order_id+'/finish';
		$.ajax({
			type: 'GET',
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			url: url,
			success: function(data, status) {
				if (data.status === 200) { return  window.location = 'my-orders'; }
			},
			error: function(data, status) {
				if (data.status === 500) {
					flash('error', data.msg);
					return  false;
				}
			},
		});
	}

	$('#update-order').click(function(event) {

		if($('#table-total').is(':visible')) {
			var order_id = $('#order_id').text();
			var list_itens = $('#tbody-total').children();
			//console.log(list_itens);
			var itens_to_update = new Array();

			$.each(list_itens, function( index, item ) {
				itens_to_update.push({'item_id': $(item).find('div :input').attr('id'), 'amount' : $(item).find('div :input').val()});
			});

			var url = 'order/'+order_id+'/update';
			$.ajax({
				type: 'POST',
				data: {'order_id' : order_id, 'itens' : itens_to_update},
				url: url,
				success: function(data, status) {
					flash('info', 'Pedido atualizado com sucesso!');
					return load_order_finish()
				},
				error: function(data, status) {
					alert('Erro ao tentar atualizar o pedido');
					flash('error', 'Erro ao atualizar quantidade dos itens de pedido! '+JSON.stringify(data));
				},
			});
		}
	});

	function load_order_finish() {

		var order_id = $('#order_id').text();
		var url = 'order/'+order_id+'/total';

		$.ajax({
			type: 'GET',
			dataType: 'json',
			contentType: "application/json; charset=utf-8",
			url: url,
			success: function(order, status) {
				if (order.itens_amount === null)  {
					$('#update-order').attr("disabled", "disabled");
					$('a[href$="#finish"]').attr("disabled", "disabled");
				} else {
					$('#update-order').removeAttr("disabled");
					$('a[href$="#finish"]').removeAttr("disabled");
				}
				$("#tbody-total").empty();
				var item_line = '';
				$.each(order.itens, function(index, item){
						//console.log(item.name);
						item_line = '<tr>'
						+ '<td>'       + item.name +'</td>'
						+ '<td>'       + item.category  +'</td>'
						+ '<td>R$ '  +Number(item.package_price).toFixed(2).replace('.',',') +'</td>'
						+ '<td> <div class="col-sm-5"><input type="number" placeholder="Quantidade"  value="'+item.amount+'" id="'+item.item_id+'" category="'+item.category+'" class="form-control" min="0"></div></td>'
						+ '<td>R$ '  +Number(item.package_price * item.amount).toFixed(2).replace('.',',')  +'</td>'
						+ '</tr>';
						$("#tbody-total").append(item_line);
					});

				(order.itens_amount === null) ? $('#itens_amount_badge').text(0) : $('#itens_amount_badge').text(order.itens_amount);

				var freight = Number(order.freight)
				var total = Number(order.total)+Number(order.freight);

				$('#total-frete').text('R$ '+freight.toFixed(2).replace('.',','));
				$('#total-pedido').text('R$ '+total.toFixed(2).replace('.',','));
			},
			error: function(data, status) {
				flash('error', 'Erro ao carregar total do pedido: '+JSON.stringify(data));
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