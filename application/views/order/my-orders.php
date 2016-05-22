<?php foreach ($orders as $key => $order) { ?>
<?php $datestring = 'Year: %Y Month: %m Day: %d - %h:%i %a'; ?>
<div class="panel-group" role="tablist">
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="collapseListGroupHeading<?= $order->id ?>">
			<h4 class="panel-title">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Nº Pedido</th>
								<th>Data</th>
								<th>Valor Total</th>
								<th>Modo de Entrega</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td ><?= $order->id ?></td>
								<td ><?= date("d/m/Y", strtotime($order->created_at)) ?></td>
								<td >R$ <?= number_format($order->total,2,",","." ); ?></td>
								<td><?= $order->delivery ?> </td>
								<td> <span class="label label-<?= ($order->status === 'Pendente') ? 'warning' : 'success' ?>"><?=  ($order->status === 'Pendente') ? 'Aguardando Aprovação' : 'Pedido Aprovado'; ?></span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<a class="" role="button" data-toggle="collapse" href="#collapseListGroup<?= $order->id ?>"  aria-controls="collapseListGroup<?= $order->id ?>">Ver mais detalhes...</a>
			</h4>
		</div>

		<div id="collapseListGroup<?= $order->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading<?= $order->id ?>" >
			<div class="panel-body">
					<div class="row">
						<div class="col-md-8">
							<div class="table-responsive">
								<table class="table table">
									<thead>
										<tr>
											<th>Nº</th>
											<th>Item</th>
											<th>Quantidade</th>
											<th>Valor Unitário</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($order->itens as $index => $item) { ?>
										<tr>
											<td><?= $item->item_id ?></td>
											<td><?= $item->name ?> </td>
											<td><?= $item->amount ?> </td>
											<td><?= $item->package_price ?> </td>
											<td>R$ <?= number_format(($item->amount * $item->package_price),2,",","." );  ?> </td>
										</tr>
									<?php } ?>
									<tr>
										<td colspan="4"><b>Frete</b></td>
										<td>R$ <?= number_format($order->freight,2,",","." ); ?></td>
									</tr>
									<tr>
										<td colspan="4"><b>Total</b></td>
										<td>R$ <?= number_format($order->total,2,",","." ); ?></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-md-4">
							<center> Endereço de Entrega </center>
							<?php if ($order->delivery === 'Entrega') { ?>
								<?php print_r($item->address->number) ?>
								<!-- <p><?=  $item->address->street.', '.$item->address->number.' - '.$item->address->complement ?></p>
								<p>Bairro: <?=  $item->address->neighborhood ?></p>
								<p>Cidade: <?=  $item->address->city ?></p>
								<p>CEP: <?=  $item->address->zip_code ?></p>
								<p><?=  $item->address->uf ?>/Brasil</p> -->
							<?php } ?>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

