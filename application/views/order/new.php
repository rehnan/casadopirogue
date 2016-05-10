<div class="page-header ">
	<a class="btn btn-default"  href="order" role="button">Novo Pedido</a>
	<button class="btn btn-primary   pull-right" type="button">
		Carrinho <span class="badge" ><?=  count($order->itens) ?></span>
	</button>

</div>
<div id="example-basic">
	<h3> Escolha dos Produtos</h3>
	<section>
		<p>ID Pedido: <span id="order_id"><?=  $order->id ?></span> Status:  <span class="label label-primary"><?=  $order->status ?></span></p>
		<form id="itens-form" name="itens-form" method="POST" action="itens">

			<input type="hidden" name="item[pedido_id]" value="<?= $order->id ?>">

			<div class="form-group  input-group-lg">
				<label  for="selecao-item">Pirogue / Pastel: </label>
				<select class="form-control" id="selecao-item" name="item[categoria]">
					<option>[Selecione um Produto]</option>
					<option <?= ($item->category === 'Pirogue') ? 'selected' : '' ?> value="Pirogue">Pirogue</option>
					<option <?= ($item->category === 'Pastel') ? 'selected' : '' ?> value="Pastel">Pastel</option>
				</select>
			</div>

			<div class="form-group  input-group-lg">
				<label  for="selecao-sabor-item">Sabor: </label>
				<select class="form-control" id="selecao-sabor-item" name="item[sabor]" disabled="disabled"></select>
			</div>

			<div class="form-group input-group-lg">
				<label  for="quantidade-item">Quantidade:</label>
				<input type="number" placeholder="Quantidade de pacotes"  value="<?= $item->amount ?>" name="item[quantidade]" class="form-control" id="quantidade-item">
			</div>
			<div class="form-group">
				<label  for="observaçao-item">Observação:</label>
				<textarea placeholder="Observações" class="form-control" rows="3 "   id="observaçao-item" name="item[observacao]"><?= $item->description ?></textarea>
			</div>
			<p class="error"><?php echo validation_errors(); ?> </p>
			<div class="form-group  input-group-lg">
				<button  type="submit" class="btn btn-default btn-lg" id="add-item"> Adicionar Item </button>
				<a class="btn btn-danger btn-lg"   id="cancelar-pedido" href="order/<?= $order->id ?>/cancel" role="button" data-toggle="confirmation">Cancelar Pedido</a>
			</div>

		</form>
	</section>

	<h3>Política de Entrega</h3>
	<section>
		<form id="delivery-policy-form" name="delivery-policy-form" method="POST" action="/delivery-policy">

			<div class="radio">
				<label>
					<input type="radio" name="opcaoDelivery" id="retirada" value="Retirada" <?= ($order->delivery === 'Retirada') ? 'checked' : '' ?> >
					Retirar o pedido em nosso estabelecimento?
				</label>
			</div>
			Ou <br>
			<div class="radio">
				<label>
					<input type="radio" name="opcaoDelivery" id="entrega" value="Entrega" <?= ($order->delivery === 'Entrega') ? 'checked' : '' ?>>
					Solicitar entrega do pedido no endereço desejado?
				</label>
				<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" href="#collapse1">Endereço 1 <i class="fa fa-truck" aria-hidden="true"></i></a>
								</h4>
							</div>
							<div id="collapse1" class="panel-collapse collapse">
								<div class="panel-body">

								</div>
							</div>
						</div>
				<!-- <?php foreach ($address  as $key => $adrs) { ?>
					<? if ($adrs->main)  { ?> -->

					<!-- <? } ?>
				<?php } ?> -->
			</div>
		</form>
	</section>
	<h3>Confirmação do Pedido</h3>
	<section>
		<p>Fechar Pedido</p>
	</section>
</div>


