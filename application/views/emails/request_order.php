<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <title>Casa do Pirogue | Requisição de Pedido</title>

  <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Roboto+Condensed:400,700italic,400italic,700,300,300italic' rel='stylesheet' type='text/css'>

  <!-- <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" /> -->
</head>
<body style="border:solid 1px #ccc;border-radius:6px;font-family:Roboto;">
  <!-- TOPO -->
  <header style="text-align:center;height:150px;padding-top:30px;">
  <div class="topo" id="topo">
    <nav class="navbar" role="navigation">
      <div class="container">
        <div class="row text-center">
          <!-- LOGO -->
          <a href="http://www.casadopirogue.com.br" title="Casa do Pirogue">
            <?php echo "<img alt='Test Image' src='http://".$_SERVER['SERVER_NAME'].base_url('assets/img/logo3.png')."' />" ; ?>
          </a>
        </div>
      </div>
    </nav>
  </div>
</header>

<section>
<h2><center>Requisição de Pedido</center></h2>
<hr>

<div style="margin-left: 30px">
<h3>Informações para Contato: </h3>
    <fieldset style="width:500px">
    <legend>Dados Pessoais:</legend>
        <article>
            <p>Cliente solicitante: <b><?php echo $order->user->name ?></b><p>
            <p>Telefone 1: <b><?php echo $order->user->phone1 ?></b><p>
            <p>Telefone 2: <b><?php echo $order->user->phone2 ?></b><p>
            <p>Email: <b><?php echo $order->user->email ?></b><p>
        </article>
        <hr>
        <article>
          <p> Aceitar Requisição de Pedido: <a href=<?php echo "http://{$_SERVER['SERVER_NAME']}/casadopirogue/order/to_approve/{$order->approve_order_link}"  ?> title="Clique para aprovar este pedido"> Aceitar Pedido </a></p>
          <p> Recusar Requisição de Pedido: <a href=<?php echo "http://{$_SERVER['SERVER_NAME']}/casadopirogue/order/to_disapprove/{$order->disapprove_order_link}"  ?> title="Clique para reijeitar este pedido"> Rejeitar Pedido </a></p>
        </article>
    </fieldset>
</div>
<div style="margin-left: 30px">
<h3>Informações do Pedido: </h3>
    <fieldset style="width:500px">
    <legend>Dados Pedido:</legend>
        <article>
          <p>Data de solicitação: <b><?php echo date("d/m/Y", strtotime($order->created_at)) ?></b></p>
          <p>Modo de Entrega: <b><?php echo $order->delivery ?></b></p>
          <p>Modo de Pagamento: <b>Dinheiro</b</p>

          <p>Itens de Pedido:</b></p>
            <table style="width:500px; min-width:500px; padding:3px" border="1">
                <tr>
                  <th>Nº</th>
                  <th>Item</th>
                  <th>Quantidade</th>
                  <th>Valor Unitário</th>
                  <th>Subtotal</th>
                </tr>
                <tbody>
                  <?php foreach ($order->itens as $index => $item) { ?>
                  <tr>
                    <td align="center"><?php echo $item->item_id ?></td>
                    <td align="center"><?= $item->name ?> </td>
                    <td align="center"><?= $item->amount ?> </td>
                    <td align="center">R$ <?= number_format($item->package_price,2,",","." ); ?> </td>
                    <td align="center">R$ <?= number_format(($item->amount * $item->package_price),2,",","." );  ?> </td>
                  </tr>
                 <?php } ?>
               </tbody>
                <tr>
        				    <td align="center" colspan="4"><b>Frete</b></td>
        				    <td align="center" >R$ <?= number_format($order->freight,2,",","." ); ?></td>
        			  </tr>
                 <tr>
        				    <td align="center" colspan="4"><b>Total</b></td>
        				    <td align="center"><b>R$ <?php echo number_format($order->total,2,",","." ); ?></b></td>
        			  </tr>
            </table>
        </article>
    </fieldset>
</div>

<?php if ($order->delivery === 'Entrega') { ?>
<div style="margin-left: 30px;">
    <h3>Informações do Endereço de Entrega: </h3>
    <fieldset style="width:500px">
    <legend>Endereço de Entrega:</legend>
        <article>
          <p>Distância de Entrega: <b><?php echo $order->distance ?>km.</b> </p>
          <p>Endereço de Entrega </p>
          <p>CEP: <b><?php echo $order->address_id->zip_code ?></b>
          <p>Rua: <b><?php echo $order->address_id->street.', '.$order->address_id->number ?></b>
          <p>Bairro: <b><?php echo $order->address_id->neighborhood ?></b>
          <p>Complemento: <b><?php echo $order->address_id->complement ?></b>
          <p>Cidade: <b><?php echo $order->address_id->city.'/'.$order->address_id->uf ?></b>
        </article>
    </fieldset>
</div>
<?php } ?>

</section>


  <footer class="rodape" style="width:100%;background:#FF6D00;min-height:100px;margin-top:200px;padding:50px 0 0 0;">
			<div class="container">
				<ul style="list-style:none;padding:0;margin:0;text-align:center;">
					<li style="display: inline-block;text-align: left;margin: 20px 50px;color:#fff;vertical-align:top;">
						<span style="font-weight: 600;font-size: 16px;display:block;text-transform: uppercase;margin-bottom:10px;">Casa do Pirogue</span>
						<p style="margin:0;text-align:left;">Rua Rei Salomão Santa Cândida</p>
						<p style="margin:0;text-align:left;">Curiritba-PR</p>
						<p style="margin:0;text-align:left;">CEP:80220430</p>
						<p style="margin:0;text-align:left;">CNPJ:48412548454</p>
					</li>

					<li style="display: inline-block;text-align: left;margin: 20px 30px;color:#fff;vertical-align:top;">
						<span style="font-weight: 600;font-size: 16px;display:block;text-transform: uppercase;margin-bottom:10px;">Horários de atendimento</span>
						<p style="margin:0;text-align:left;">Seg-Sex:</p>
						<p style="margin:0;text-align:left;">Das 8:00h á 18:00h</p>
						<p style="margin:0;text-align:left;">Sáb:</p>
						<p style="margin:0;text-align:left;">Das 8:00h á 12:00h</p>
					</li>


				</ul>

				<div class="copyright" style="text-align: center;width: 100%;margin-top: 70px;background: #FF6D00;">
					<i class="fa fa-copyright" style="color:#fff;" aria-hidden="true"></i><p style="display: inline;color: #fff;margin: 0 5px;font-size: 15px;">Casa do Pirogue - Todos os direitos reservados</p>
			</div>
		</div>
  </footer>
  </body>
  </html>
