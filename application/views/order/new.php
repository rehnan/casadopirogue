<div class="page-header ">
	ID Pedido: <span id="order_id"><?=  (isset($order)) ? $order->id : '' ?></span> Status:  <span class="label label-primary"><?=  (isset($order)) ? $order->status : '' ?></span>
<button class="btn btn-primary   pull-right" type="button">
	<i class="fa fa-shopping-cart" title="Você possui <?=  (isset($order) && is_null($order->itens_amount)) ? 0 : $order->itens_amount ?> itens em seu carrinho" aria-hidden="true"></i> Carrinho <span class="badge" id="itens_amount_badge"><?=  (is_null($order->itens_amount)) ? 0 : $order->itens_amount ?></span>
</button>
</div>

<div id="example-basic">
	<h3>Escolha dos Produtos <i class="fa fa-shopping-basket" title="Escolha seu Produtos"></i></h3>
	<section>
		<form id="itens-form" name="itens-form" method="POST" action="itens">

			<input type="hidden" name="item[pedido_id]" value="<?= (isset($order)) ? $order->id : '' ?>">

			<div class="form-group  input-group-sm">
				<label  for="selecao-item">Pirogue / Pastel: </label>
				<select class="form-control" id="selecao-item" name="item[categoria]">
					<option>[Selecione um Produto]</option>
					<option <?= ($item->category === 'Pirogue') ? 'selected' : '' ?> value="Pirogue">Pirogue</option>
					<option <?= ($item->category === 'Pastel') ? 'selected' : '' ?> value="Pastel">Pastel</option>
				</select>
			</div>

			<div class="form-group  input-group-sm">
				<label  for="selecao-sabor-item">Sabor: </label>
				<select class="form-control" id="selecao-sabor-item" name="item[sabor]" disabled="disabled"></select>
			</div>

			<div class="form-group input-group-sm">
				<label  for="quantidade-item">Quantidade de pacotes:</label>
				<input type="number" placeholder="Quantidade de pacotes"  value="<?= $item->amount ?>" name="item[quantidade]" class="form-control" id="quantidade-item">
			</div>
			<p class="error"><?php echo validation_errors(); ?> </p>
			<div class="form-group  input-group-sm">
				<button  type="submit" class="btn btn-default btn-sm" id="add-item"> Adicionar Item </button>
				<a class="btn btn-danger btn-sm"   id="cancelar-pedido" href="<?= base_url("order/$order->id/cancel") ?>" role="button" data-toggle="confirmation">Cancelar Pedido</a>
			</div>

		</form>
	</section>

	<h3>Modo de Entrega <i class="fa fa-truck" title="Modo de Entrega"></i></h3>
	<section>
		<form id="delivery-policy-form" name="delivery-policy-form" method="POST" action="/delivery-policy">
			<div class="form-inline">
					<label  for="date-delivery">Data para Retirada/Entrega:</label>
					<div class="input-group">
					  <input type="date" class="form-control" id="date-delivery" name="date-delivery" value="<?= (isset($order->delivery_date)) ? $order->delivery_date : date("Y-m-d", now()); ?>">
						<span class="input-group-btn">
		        	<button class="btn btn-default" type="button" id="update-delivery-date">
								<i class="fa fa-edit" title="Salvar Alteração"></i>
							</button>
	      		</span>
				 </div>
			</div>
			
			<div class="radio">
				<label>
					<input type="radio" name="opcaoDelivery" id="retirada" value="Retirada" <?= ($order->delivery === 'Retirada') ? 'checked' : '' ?> >
					<b>Retirar o pedido no estabelecimento.</b>
				</label>
			</div>
			Ou 
			<div class="radio">
				<label>
					<input type="radio" name="opcaoDelivery" id="entrega" value="Entrega" <?= ($order->delivery === 'Entrega') ? 'checked' : '' ?>>
					<b>Solicitar entrega do pedido em meu endereço principal.</b>
				</label>
			</div>
			<?php if ($order->address_id) { ?>
			<div id="address_main">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#collapse1"><i class="fa fa-truck" aria-hidden="true"></i> <span id="address_id"><?= $order->address_id->id ?></span> | <?= $order->address_id->address_name  ?></a>
						<div  class="pull-right" > Distância: <b><span id="distancia"><?=  $order->distance ?>Km</span></b>. Preço Frete: <b><span id="frete"><?=  number_format($order->freight,2,",",".")  ?></span></b></div>
					</h4>
				</div>

				<div id="collapse1" class="panel-collapse collapse">
					<div class="panel-body">
						<p><span id="rua"><?= $order->address_id->street.', '.$order->address_id->number ?></span> <?= $order->address_id->complement ?> </p>
						<p>Bairro: <span id="bairro"><?= $order->address_id->neighborhood  ?></span></p>
						<p>Cidade: <span id="cidade"><?= $order->address_id->city  ?></span></p>
						<p>CEP: <span id="cep"><?= $order->address_id->zip_code  ?></span></p>
						<p>Estado: <span id="estado"><?= $order->address_id->uf  ?></span></p>
						<p><a href="address" name="trocar-endereco"> Mudar Endereço Principal </a></p>
					</div>
				</div>

				<div >
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" id="showMapsRoute" href="#collapseMaps"> <i class="fa fa-map-marker" aria-hidden="true"></i> Rota de Entrega
							</a>
						</h4>
					</div>
					<div id="collapseMaps" class="panel-collapse collapse in">
						<div id="map" style="width:100%; height:300px"></div>
					</div>
				</div>
			</div>

			<?php } else { ?>
			<div class="alert alert-warning" id="set-main-address-flash">
				Você não possui nenhum endereço principal configurado.<strong> <a title="Endereços" href="address" >Clique aqui para cadastrá-los e configurá-los.</a></strong>
			</div>
			<?php } ?>
		</form>


	</section>

	<h3>Confirmação do Pedido <i class="fa fa-thumbs-o-up" title="Modo de Entrega"></i></h3>
	<section>
		<div class="tabela-pedido">	
			<table id="table-total" class="table table-striped">
				<thead>
					<tr>
						<th>Item</th>
						<th>Categoria</th>
						<th>Valor Pacote (UN)</th>
						<th>Quantidade</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody id="tbody-total"></tbody>
				<tr>
					<td colspan="4"><b>Frete</b></td>
					<td><span id="total-frete"></span></td>
				</tr>
				<td><b>Total Pedido</b></td>
				<td></td>
				<td></td>
				<td></td>
				<td><b><span id="total-pedido"></span></b></td>
			</table>
		</div>	
		
		<i class="fa fa-credit-card-alt" title="Modo de Pagamento"></i> Informe o modo de pagamento:
		<form id="delivery-policy-form" name="delivery-policy-form" method="POST" action="/payment-mode">

			<div class="radio">
				<label>
					<input type="radio" name="opcaoModoPagamento" id="dinheiro" value="Dinheiro"  <?= ($order->payment_mode === 'Dinheiro') ? 'checked' : '' ?> >
					1. Dinheiro
				</label>
			</div>

			<div class="radio">
				<label>
					<input type="radio" name="opcaoModoPagamento" id="cartao-credito" value="Cartão de Crédito" <?= ($order->payment_mode === 'Cartão de Crédito') ? 'checked' : '' ?> >
					2. Cartão de Crédito
				</label>
			</div>

		<button type="button" class="btn btn-primary" id="update-order" title="Atualizar Pedido">Salvar Alterações</button>
	</section>
</div>
