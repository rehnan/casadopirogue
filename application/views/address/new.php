<session>
	<form method="POST" action="<?= base_url('address/new') ?>" id="cadastro-endereco" name="cadastro-endereco">
		<div class="form-group">
			<label  for="address[name]">Nome do Endereço: </label>
			<input type="text"  class="form-control" id="name" name="address[name]" placeholder="Nome do Endereço"  value="<?= $address->address_name ?>" />
		</div>

		<div class="form-group">
			<label  for="address[cep]">CEP: </label>
			<input type="text"  class="form-control" id="zip_code" name="address[cep]" placeholder="CEP"  value="<?= $address->zip_code ?>"/>
		</div>

		<div class="form-group">
			<label  for="address[street]">Endereço: </label><br>
			<input type="text"  class="form-control" id="street" name="address[street]" placeholder="Nome do Endereço" value="<?= $address->street ?>" />
		</div>

		<div class="form-inline">
			<div class="form-group">
				<label  for="address[number]">Número: </label><br>
				<input type="number"  class="form-control" id="number" name="address[number]" placeholder="Número" value="<?= $address->number ?>" />
			</div>


			<div class="form-group">
				<label  for="address[complement]">Complemento: </label><br>
				<input type="text"  class="form-control" id="complement" name="address[complement]" placeholder="Complemento" value="<?= $address->complement ?>" />
			</div>

			<div class="form-group">
				<label  for="address[neighborhood]">Bairro: </label><br>
				<input type="text"  class="form-control" id="neighborhood" name="address[neighborhood]" placeholder="Bairro" value="<?= $address->neighborhood ?>" />
			</div>
		</div>
		<br>
		<div class="form-inline">
			<div class="form-group">
				<label  for="address[uf]">Estado: </label><br>
				<select  class="form-control" id="uf" name="address[uf]">
					<option>PR</option>
				</select>
			</div>

			<div class="form-group">
				<label  for="address[city]">Cidade: </label><br>
				<input type="text"  class="form-control" id="city" name="address[city]" placeholder="Cidade" value="<?= $address->city ?>" />
			</div>
		</div>

		<div class="form-group pull-right">
			<button type="submit" class="btn btn-primary" name="salvar-endereco">Salvar Endereço</button>
		</div>
	</form>
	<br>
	<p class="error"><?php echo validation_errors(); ?> </p>
</session>
