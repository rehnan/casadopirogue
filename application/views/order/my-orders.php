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
								<table class="table table-bordered table-striped">
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
											<td>R$ <?=  number_format($item->package_price,2,",","." ); ?> </td>
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
							<center> Endereço para	 Retirada </center>
							<?php if ($order->delivery === 'Retirada') { ?>
								<?php print_r($item->address->number) ?>
								<!-- <p><?=  $item->address->street.', '.$item->address->number.' - '.$item->address->complement ?></p>
								<p>Bairro: <?=  $item->address->neighborhood ?></p>
								<p>Cidade: <?=  $item->address->city ?></p>
								<p>CEP: <?=  $item->address->zip_code ?></p>
								<p><?=  $item->address->uf ?>/Brasil</p> -->
								<div class="embed-responsive embed-responsive-4by3" >
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4838.2573169111265!2d-49.2433969896013!3d-25.374666196112454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dce65918e2edeb%3A0x52a3db81ee2910b7!2sR.+Prof.+Rodolfo+Belz%2C+369+-+Santa+C%C3%A2ndida%2C+Curitiba+-+PR!5e0!3m2!1spt-BR!2sbr!4v1463952185379" width="500" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
								</div>
							<?php } ?>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

