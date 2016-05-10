<section>
	<div class="page-header ">
		<a class="btn btn-default"  href="<?= base_url('address/new') ?>" role="button">Adicionar novo Endereço</a>
	</div>
</section>

<session>

	<?php foreach ($address  as $key => $adrs) { ?>
	<div class="col-md-4" style="padding: 1%">
		<div class="panel panel-default">
			<div class="panel-heading"><?= ($adrs->main) ? "<i class='fa fa-star' aria-hidden='true' title='Endereço Principal'></i>&nbsp;" : '' ?><b><?=  $adrs->address_name ?></b></div>
			<div class="panel-body">
				<p><?=  $adrs->street.', '.$adrs->number.' - '.$adrs->complement ?></p>
				<p>Bairro: <?=  $adrs->neighborhood ?></p>
				<p>Cidade: <?=  $adrs->city ?></p>
				<p>CEP: <?=  $adrs->zip_code ?></p>
				<p><?=  $adrs->uf ?>/Brasil</p>
			</div>
			<div class="panel-footer">
				<a href="#" name="editar-endereco"> Editar </a>|
				<a href='<?=  base_url("address/$adrs->id/delete")  ?>' name="excluir-endereco"> Excluir </a>|
				<?= (!$adrs->main) ? "<a href='".base_url("address/$adrs->id/main")."'  name='checkar-como-principal'>Marcar como Principal</a>" : '' ?>
			</div>
		</div>
	</div>
	<?php } ?>

</session>