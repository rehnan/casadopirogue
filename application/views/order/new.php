

  <div class="page-header ">

    <button class="btn btn-default" id="add-produto"> Novo Pedido </button>
<button class="btn btn-primary   pull-right" type="button">
 Carrinho <span class="badge"><?=  $itens_order ?></span>
</button>

</div>
<div id="example-basic">
  <h3> Escolha dos Produtos</h3>
  <section>
    <p>ID Pedido: <span id="order_id"><?=  $order->id ?></span> Status:  <?=  $order->status ?></p>
    <form id="itens-form" name="itens-form">
   <div class="form-group  input-group-lg">
        <label  for="selecao-item">Pirogue / Pastel: </label>
        <select class="form-control" id="selecao-item" name="selecao-tem">
         <option>[Selecione um Produto]</option>
         <option value="Pirogue">Pirogue</option>
         <option value="Pastel">Pastel</option>
       </select>
     </div>

     <div class="form-group  input-group-lg">
      <label  for="selecao-sabor-item">Sabor: </label>
      <select class="form-control" id="selecao-sabor-item" name="selecao-sabor-item" disabled="disabled"></select>
    </div>

    <div class="form-group input-group-lg">
      <label  for="quantidade-item">Quantidade:</label>
      <input type="number" placeholder="Quantidade de pacotes" name="quantidade-item" class="form-control" id="quantidade-item">
    </div>
    <div class="form-group">
      <label  for="observaçao-item">Observação:</label>
      <textarea placeholder="Observações" class="form-control" rows="3 "   id="observaçao-item" name="observaçao-item"></textarea>
    </div>

    <div class="form-group  input-group-lg">
     <button class="btn btn-default btn-lg" id="add-item"> Adicionar Item </button>

     <button class="btn btn-default btn-lg" id="cancelar-pedido"> Cancelar Pedido</button>
    </div>
 </form>

</section>
<h3>Política de Entrega</h3>
<section>
 <p>Informar política de Entrega (Retirar no Local, Informar Endereço de Entrega)</p>
</section>
<h3>Confirmação do Pedido</h3>
<section>
 <p>Fechar Pedido</p>
</section>
</div>


